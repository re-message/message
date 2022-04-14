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

namespace RM\Standard\Message\Format;

/**
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
abstract class DecoratedMessageFormatter implements MessageFormatterInterface
{
    public function __construct(
        private readonly MessageFormatterInterface $formatter,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function encode(array $message): string
    {
        return $this->formatter->encode($message);
    }

    /**
     * @inheritDoc
     */
    public function decode(string $message): array
    {
        return $this->formatter->decode($message);
    }
}