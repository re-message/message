<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
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
 * Interface MessageSerializerInterface.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
interface MessageSerializerInterface
{
    /**
     * Serializes the message into transfer-safe string format.
     *
     * @param MessageInterface $message
     *
     * @return string
     */
    public function serialize(MessageInterface $message): string;

    /**
     * Parses the message from transfer-safe format.
     *
     * @param string $message
     *
     * @return MessageInterface
     */
    public function deserialize(string $message): MessageInterface;

    /**
     * @param MessageInterface|string $message
     *
     * @return bool
     */
    public function supports($message): bool;
}
