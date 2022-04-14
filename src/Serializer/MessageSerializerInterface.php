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

namespace RM\Standard\Message\Serializer;

use RM\Standard\Message\MessageInterface;

/**
 * @author Oleg Kozlov <h1karo@relmsg.ru>
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
