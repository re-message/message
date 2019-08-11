<?php
/**
 * Relations Messenger API Message Standard
 *
 * @link      https://gitlab.com/relmsg/message
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 */

namespace RM\API\Message;

/**
 * Class MessageEncoder
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class MessageEncoder
{
    /**
     * @var array list of supported message types
     */
    protected $registry = [];
    
    /**
     * @param MessageInterface $message
     *
     * @return string
     * @throws ExplanatoryException
     */
    final public function encode(MessageInterface $message): string
    {
        if (!array_key_exists($message->getType(), $this->registry)) {
            throw new ExplanatoryException("Messages of this type are not supported.", $message);
        }
        
        $serialized = $message->serialize();
        if (null !== $parsed = $this->parse($serialized)) {
            return $parsed;
        } else {
            throw new ExplanatoryException("Unable to parse the message.", $serialized);
        }
    }
    
    /**
     * Parses the array of type and content of message to string.
     * If unable to parse the message, returns null.
     *
     * @param array $message
     *
     * @return string|null
     */
    abstract protected function parse(array $message): ?string;
}