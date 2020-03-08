<?php
/**
 * This file is a part of Relations Messenger API Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @link      https://gitlab.com/relmsg/message
 * @link      https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message;

use RM\Standard\Message\Exception\ExplanatoryException;
use RM\Standard\Message\Exception\MissingParameterException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

/**
 * Abstract class for actions.
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 * @see     MessageType::ACTION
 */
abstract class Action implements ValidatableMessageInterface
{
    private array $parameters = [];

    /**
     * Any data should NOT be passed with constructor.
     * Please use setters instead.
     */
    final public function __construct() { }

    /**
     * The unique name of action.
     *
     * @return string
     * @see https://dev.relmsg.ru/api/methods
     */
    abstract public static function getName(): string;

    /**
     * The constraints for all parameters.
     * Format: parameter => constraints
     *
     * @return Constraint[][] Parameters constraints for this action.
     */
    abstract protected function getConstraints(): array;

    /**
     * The constraints for parameter.
     *
     * @param string|null $parameter The name of parameter.
     *
     * @return Constraint[]|null Parameter constraints or null if there are no constraints.
     */
    protected function getParameterConstraints(string $parameter): ?array
    {
        $constraints = $this->getConstraints();
        if (!array_key_exists($parameter, $constraints)) {
            return null;
        }

        return $constraints[$parameter];
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return MessageType::ACTION;
    }

    /**
     * Bind given value to parameter and validate him.
     *
     * @param string $parameter
     * @param mixed  $value
     *
     * @return bool
     * @throws MissingParameterException
     * @throws ExplanatoryException
     */
    final public function bind(string $parameter, $value): bool
    {
        if (!array_key_exists($parameter, $this->getConstraints())) {
            throw new MissingParameterException($parameter, static::getName());
        }

        if (is_object($value) || is_resource($value)) {
            $type = gettype($value);
            throw new ExplanatoryException(
                sprintf('You cannot use this value type (%s) to send messages.', $type),
                $value,
                'Serialize your value.'
            );
        }

        $violations = $this->validateValue($parameter, $value);
        if ($violations->count() !== 0) {
            $violation = $violations->get(0);
            throw new ExplanatoryException(
                sprintf(
                    'This value is not compliance with parameter constraints: %s (%s).',
                    $violation->getMessage(),
                    $violation->getCode()
                ),
                $value, null,
                sprintf('https://dev.relmsg.ru/api/method/%s#parameter-%s', static::getName(), $parameter)
            );
        }

        $this->parameters[$parameter] = $value;
        return true;
    }

    /**
     * Binds all parameters with validation.
     *
     * @param array $parameters
     *
     * @return bool
     * @throws ExplanatoryException
     */
    final public function bindAll(array $parameters): bool
    {
        foreach ($parameters as $parameter => $value) {
            if (false === $this->bind($parameter, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the current value of the parameter or null if it does not exist.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    final protected function getBoundValue(string $name)
    {
        return $this->parameters[$name] ?? null;
    }

    /**
     * Checks the existence of value for the parameter.
     *
     * @param string $name
     *
     * @return bool
     */
    final protected function hasBoundValue(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Returns the current parameter value or the default value or null.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    final public function getValue(string $name)
    {
        return $this->getBoundValue($name) ?? $this->getDefaultValue($name);
    }

    /**
     * Checks the existence of value or default value for parameter.
     *
     * @param string $name
     *
     * @return bool
     */
    final public function hasValue(string $name): bool
    {
        return $this->hasBoundValue($name) || $this->hasDefaultValue($name);
    }

    /**
     * Returns a default values for action parameters.
     * You can override this method to provide default values.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return [];
    }

    /**
     * Returns the default value for parameter or null if it does not exist.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    final public function getDefaultValue(string $name)
    {
        $defaults = $this->getDefaultValues();
        return $defaults[$name] ?? null;
    }

    /**
     * Checks the existence of default value for the parameter.
     *
     * @param string $name
     *
     * @return bool
     */
    final public function hasDefaultValue(string $name): bool
    {
        return array_key_exists($name, $this->getDefaultValues());
    }

    /**
     * @inheritDoc
     */
    final public function validateAll(): ConstraintViolationListInterface
    {
        $violations = new ConstraintViolationList();

        foreach (array_keys($this->getConstraints()) as $parameter) {
            $v = $this->validateParameter($parameter);
            $violations->addAll($v);
        }

        return $violations;
    }

    /**
     * @inheritDoc
     */
    final public function validateValue(string $parameter, $value): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();
        $constraints = $this->getParameterConstraints($parameter);
        return $validator->validate($value, $constraints);
    }

    /**
     * @inheritDoc
     */
    final public function validateParameter(string $parameter): ConstraintViolationListInterface
    {
        return $this->validateValue($parameter, $this->getValue($parameter));
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => static::getName(),
            'parameters' => $this->parameters
        ];
    }
}