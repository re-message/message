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