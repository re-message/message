<?php
/**
 * A Relations Messenger SDK
 *
 * @link      https://gitlab.com/relmsg/php-sdk
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/sdk
 */

namespace RM\API\Message;

/**
 * Enum MessageType
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
interface MessageType
{
    /**
     * Main message type. Means the requirement to perform some action. For example, get the user for the `users.get` action.
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
}