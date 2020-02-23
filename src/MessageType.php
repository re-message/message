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

use ReflectionClass;
use ReflectionException;

/**
 * Enum MessageType
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class MessageType
{
    /**
     * Main message type. Means the requirement to perform some action.
     * For example, get the user for the `users.get` action.
     * Sent only by client.
     *
     * @see Action
     */
    const ACTION = 'action';
    /**
     * Response from server on client action message.
     * Sent only by server.
     *
     * @see Response
     */
    const RESPONSE = 'response';
    /**
     * Subscribe on some event. Without this server will not send event messages.
     * Sent only by client.
     *
     * @see Subscription
     */
    const SUBSCRIPTION = 'subscription';
    /**
     * Means that a certain event has occurred on the server that the client MAY process.
     * The client cannot send this type of message. They will be ignored by the server.
     * Only works for socket connection.
     *
     * @see Event
     */
    const EVENT = 'event';
    /**
     * Means that an error occurred while processing the last message from the client.
     * The client cannot send this type of message. They will be ignored by the server.
     *
     * @see Error
     */
    const ERROR = 'error';
    /**
     * Means server comment. No processing required. Such messages will simply be logged and nothing more.
     * The client cannot send this type of message. They will be ignored by the server.
     * Only works for socket connection.
     *
     * @see Comment
     */
    const COMMENT = 'comment';

    /**
     * Checks if this type of message exists
     *
     * @param string $type guess message type
     *
     * @return bool
     */
    public static function exists(string $type): bool
    {
        $type = mb_strtoupper($type);
        return array_search($type, self::all()) !== false;
    }

    /**
     * Returns list of all message types
     *
     * @return array
     */
    public static function all(): array
    {
        try {
            $reflect = new ReflectionClass(get_called_class());
            return array_keys($reflect->getConstants());
        } catch (ReflectionException $e) {
            return [];
        }
    }
}