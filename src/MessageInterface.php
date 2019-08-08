<?php

namespace RM\API\Message;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class Message
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
interface MessageInterface
{
    /**
     * Type of the message
     *
     * @return string
     * @see MessageType
     */
    public function getType(): string;
    
    /**
     * Content of the message
     *
     * @return string|int|array
     */
    public function getContent();
    
    /**
     * Returns list of violations. If the list is empty validate succeeded.
     *
     * @return ConstraintViolationListInterface
     * @see ValidatorInterface::validate()
     */
    public function validate(): ConstraintViolationListInterface;
}