<?php
/**
 * Relations Messenger Message Standard
 *
 * @link      https://gitlab.com/relmsg/message
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 */

namespace RM\API\Message;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Basic action class
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 * @see MessageType::ACTION
 */
abstract class Action implements MessageInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $arguments;
    /**
     * @var array
     */
    private $values;
    
    /**
     * Action constructor.
     *
     * @param string $name      unique name of API action
     * @param array  $arguments API action arguments and they constraints
     * @param array  $values    values of arguments
     *
     * @see ValidatorInterface::validate()
     */
    public function __construct(
        string $name,
        array $arguments = [],
        array $values = []
    ) {
        $this->name = $name;
        $this->arguments = $arguments;
        $this->values = $values;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return MessageType::ACTION;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->values;
    }
    
    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }
    
    /**
     * {@inheritDoc}
     */
    public function validate(): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();
        $violations = new ConstraintViolationList();
        foreach ($this->arguments as $argument => $constraints) {
            $v = $validator->validate($this->values[$argument], $constraints);
            $violations->addAll($v);
        }
        return $violations;
    }
}