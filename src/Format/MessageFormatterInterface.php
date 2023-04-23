<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2023 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
