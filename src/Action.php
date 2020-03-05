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

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Abstract class for actions.
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 * @see     MessageType::ACTION
 */
abstract class Action implements ValidatableMessageInterface
{
    private static ?ValidatorInterface $validator = null;

    /**
     * Unique name of action.
     *
     * @var string
     * @see https://dev.relmsg.ru/api/methods
     */
    private string $name;
    private array $constraints;
    private array $parameters = [];

    /**
     * Action constructor.
     *
     * @param string $name        unique name of API action
     * @param array  $constraints list of constraints for each action parameter.
     *                            MUST be passed in a child class. No when calling the constructor.
     *
     * @see ValidatorInterface::validate()
     */
    public function __construct(string $name, array $constraints = [])
    {
        $this->name = $name;
        $this->constraints = $constraints;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return MessageType::ACTION;
    }

    /**
     * @param string $parameter
     * @param mixed  $value
     *
     * @return bool
     * @throws ExplanatoryException
     */
    final public function bind(string $parameter, $value): bool
    {
        if (!array_key_exists($parameter, $this->constraints)) {
            throw new ExplanatoryException(
                sprintf('Parameter with name `%s` for action `%s` is not exists.', $parameter, $this->getName()),
                $parameter, null,
                sprintf('https://dev.relmsg.ru/api/method/%s', $this->getName())
            );
        }

        if (is_object($value) || is_resource($value)) {
            $type = gettype($value);
            throw new ExplanatoryException(
                "You cannot use this value type ({$type}) to send messages.",
                $value,
                'Serialize your value.'
            );
        }

        $violations = $this->validateValue($parameter, $value);
        if ($violations->count() !== 0) {
            $violation = $violations->get(0);
            throw new ExplanatoryException(
                sprintf(
                    'This value is not compliance with parameter constraints: %s (%s)',
                    $violation->getMessage(),
                    $violation->getCode()
                ),
                $value, null,
                sprintf('https://dev.relmsg.ru/api/method/%s#parameter-%s', $this->getName(), $parameter)
            );
        }

        $this->parameters[$parameter] = $value;
        return true;
    }

    /**
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
     * @inheritDoc
     */
    final public function validateAll(): ConstraintViolationListInterface
    {
        $violations = new ConstraintViolationList();

        foreach (array_keys($this->constraints) as $parameter) {
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
        $validator = self::getValidator();
        $constraints = $this->constraints[$parameter];
        return $validator->validate($value, $constraints);
    }

    /**
     * @inheritDoc
     */
    final public function validateParameter(string $parameter): ConstraintViolationListInterface
    {
        return $this->validateValue($parameter, $this->parameters[$parameter]);
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->name,
            'parameters' => $this->parameters
        ];
    }

    private static function getValidator(): ValidatorInterface
    {
        if (self::$validator === null) {
            self::$validator = Validation::createValidator();
        }

        return self::$validator;
    }
}