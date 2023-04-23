<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message;

use JsonSerializable;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
enum MessageType: string implements JsonSerializable
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

    public function toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
