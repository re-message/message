<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message;

/**
 * Enum MessageType.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
enum MessageType: string
{
    /**
     * Main message type. Means the requirement to perform some action.
     * For example, get the user for the `users.get` action.
     * Sent only by client.
     *
     * @see Action
     */
    case ACTION = 'action';

    /**
     * Response from server on client action message.
     * Sent only by server.
     *
     * @see Response
     */
    case RESPONSE = 'response';

    /**
     * Subscribe on some event. Without this server will not send event messages.
     * Sent only by client.
     *
     * @see Subscription
     */
    case SUBSCRIPTION = 'subscription';

    /**
     * Means that a certain event has occurred on the server that the client MAY process.
     * The client cannot send this type of message. They will be ignored by the server.
     * Only works for socket connection.
     *
     * @see Event
     */
    case EVENT = 'event';

    /**
     * Means that an error occurred while processing the last message from the client.
     * The client cannot send this type of message. They will be ignored by the server.
     *
     * @see Error
     */
    case ERROR = 'error';

    /**
     * Means server comment. No processing required. Such messages will simply be logged and nothing more.
     * The client cannot send this type of message. They will be ignored by the server.
     * Only works for socket connection.
     *
     * @see Comment
     */
    case COMMENT = 'comment';
}
