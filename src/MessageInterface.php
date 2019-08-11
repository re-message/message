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
     * Converts the message in simple array for encoding to others formats.  Uses by {@see MessageEncoder}
     *
     * @return array
     * @see MessageEncoder::encode()
     */
    public function serialize(): array;
    
    /**
     * Create a new message instance from array. Uses by {@see MessageDecoder}
     *
     * @param array $message
     *
     * @return static|null
     * @see MessageDecoder::decode()
     */
    public static function unserialize(array $message);
}