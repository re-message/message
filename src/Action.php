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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Standard\Message\Exception\InvalidParameterException;
use RM\Standard\Message\Exception\UnknownParameterException;
use RM\Standard\Message\Exception\NonSerializableTypeException;
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
    private Collection $parameters;

    /**
     * Any data should NOT be passed with the constructor.
     * Please use setters instead.
     */
    final public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    /**
     * The unique name of action.
     *
     * @return string
     * @see https://dev.relmsg.ru/api/actions
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
     * @param string|null $name The name of parameter.
     *
     * @return Constraint[]|null Parameter constraints or null if there are no constraints.
     */
    protected function getParameterConstraints(string $name): ?array
    {
        if (!$this->hasParameter($name)) {
            return null;
        }

        $constraints = $this->getConstraints();
        return $constraints[$name];
    }

    /**
     * Checks the existence of parameter by name.
     * The parameter should be defined in {@see getConstraints()}.
     *
     * @param string $name
     *
     * @return bool
     */
    final public function hasParameter(string $name): bool
    {
        return array_key_exists($name, $this->getConstraints());
    }

    /**
     * @inheritDoc
     */
    final public function getType(): string
    {
        return MessageType::ACTION;
    }

    /**
     * Bind given value to parameter and validate him.
     *
     * @param string $parameter
     * @param mixed  $value
     *
     * @throws UnknownParameterException
     * @throws NonSerializableTypeException
     * @throws InvalidParameterException
     */
    final public function bind(string $parameter, $value): void
    {
        if (!$this->hasParameter($parameter)) {
            throw new UnknownParameterException($parameter, static::getName());
        }

        if (is_object($value) || is_resource($value)) {
            throw new NonSerializableTypeException($value);
        }

        $violations = $this->validateValue($parameter, $value);
        if ($violations->count() !== 0) {
            $violation = $violations->get(0);
            throw new InvalidParameterException(static::getName(), $parameter, $value, $violation);
        }

        $this->parameters->set($parameter, $value);
    }

    /**
     * Binds all parameters with validation.
     *
     * @param iterable $parameters
     *
     * @throws UnknownParameterException
     * @throws NonSerializableTypeException
     * @throws InvalidParameterException
     */
    final public function bindAll(iterable $parameters): void
    {
        foreach ($parameters as $parameter => $value) {
            $this->bind($parameter, $value);
        }
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
        return $this->parameters->get($name);
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
        return $this->parameters->containsKey($name);
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
        if ($this->hasDefaultValue($parameter) && !$this->hasBoundValue($parameter)) {
            return new ConstraintViolationList();
        }

        return $this->validateValue($parameter, $this->getBoundValue($parameter));
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => static::getName(),
            'parameters' => $this->parameters->toArray()
        ];
    }
}