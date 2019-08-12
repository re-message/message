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
 * Class MessageDecoder
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class MessageDecoder
{
    /**
     * @var string default message type if unable to define the message type
     */
    protected static $defaultType = MessageType::ACTION;

    /**
     * @var array list of supported message types
     */
    protected $registry = [];

    /**
     * @param string $message
     *
     * @return MessageInterface
     * @throws ExplanatoryException
     */
    final public function decode(string $message): MessageInterface
    {
        if (null === $parsed = $this->parse($message)) {
            throw new ExplanatoryException("An error occurred while message decoding.", $message);
        }

        if (array_key_exists('type', $parsed) && array_key_exists($parsed['type'], $this->registry)) {
            $type = $parsed['type'];
        } else {
            $type = self::$defaultType;
        }

        unset($parsed['type']);

        $class = $this->registry[$type];
        if (!array_search(MessageInterface::class, class_implements($class))) {
            throw new ExplanatoryException("Class {$class} for type {$type} not implement MessageInterface.", $type);
        }

        return $class::unserialize($parsed);
    }

    /**
     * Parses string message in array. If unable to parse the message, returns null.
     * This method does not check the correctness of the message, but only translates it into a format for further processing.
     *
     * @param string $message
     *
     * @return array|null
     */
    abstract protected function parse(string $message): ?array;
}