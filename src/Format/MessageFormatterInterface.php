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

namespace RM\Standard\Message\Format;

use RM\Standard\Message\Exception\FormatterException;

/**
 * Interface MessageFormatterInterface provides method for formatting message like JSON.
 * This class, that implements this, should NOT creates message objects.
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface MessageFormatterInterface
{
    /**
     * Encodes the message into some format.
     *
     * @throws FormatterException
     */
    public function encode(array $message): string;

    /**
     * Decodes the message from some format.
     *
     * @throws FormatterException
     */
    public function decode(string $message): array;
}
