<?php

/*
 * This file is part of Message Standard.
 *
 * (c) 2018-present Re Message
 *     Oleg Kozlov <h1karo@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://dev.remessage.ru/packages/message
 * https://github.com/re-message/message
 */

namespace RM\Standard\Message\Serializer;

use RM\Standard\Message\MessageInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface MessageSerializerInterface
{
    /**
     * Serializes the message into transfer-safe string format.
     */
    public function serialize(MessageInterface $message): string;

    /**
     * Parses the message from transfer-safe format.
     */
    public function deserialize(string $message): MessageInterface;

    /**
     * Checks that serializer supports this message.
     */
    public function supports(MessageInterface|string $message): bool;
}
