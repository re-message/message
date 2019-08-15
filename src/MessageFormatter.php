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
abstract class MessageFormatter
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
     * @var MessageHandler[]
     */
    private $handlers = [];

    /**
     * @param MessageInterface $message
     *
     * @return string
     * @throws ExplanatoryException
     */
    final public function encode(MessageInterface $message): string
    {
        foreach ($this->handlers as $handler) {
            if (!$handler->handlePreEncode($message)) {
                return null;
            }
        }

        if (!array_key_exists($message->getType(), $this->registry)) {
            throw new ExplanatoryException("Messages of this type are not supported.", $message);
        }

        $serialized = $message->serialize();
        if (null !== $parsed = $this->implode($serialized)) {
            foreach ($this->handlers as $handler) {
                if (!$handler->handlePostEncode($parsed)) {
                    return null;
                }
            }

            return $parsed;
        } else {
            throw new ExplanatoryException("Unable to parse the message.", $serialized);
        }
    }

    /**
     * @param string $message
     *
     * @return MessageInterface
     * @throws ExplanatoryException
     */
    final public function decode(string $message): MessageInterface
    {
        foreach ($this->handlers as $handler) {
            if (!$handler->handlePreDecode($message)) {
                return null;
            }
        }

        if (null === $parsed = $this->explode($message)) {
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

        $unserialize = $class::unserialize($parsed);
        foreach ($this->handlers as $handler) {
            if (!$handler->handlePostDecode($unserialize)) {
                return null;
            }
        }
        return $unserialize;
    }

    /**
     * @param MessageHandler $handler
     */
    final public function putHandler(MessageHandler $handler): void
    {
        $this->handlers[] = $handler;
    }

    /**
     * Parses the array of type and content of message to string.
     * If unable to parse the message, returns null.
     *
     * @param array $message
     *
     * @return string|null
     */
    abstract protected function implode(array $message): ?string;

    /**
     * Parses string message in array. If unable to parse the message, returns null.
     * This method does not check the correctness of the message, but only translates it into a format for further processing.
     *
     * @param string $message
     *
     * @return array|null
     */
    abstract protected function explode(string $message): ?array;
}