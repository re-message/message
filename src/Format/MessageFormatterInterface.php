<?php
/**
 * This file is a part of Relations Messenger API Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/message
 * @link      https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
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
 * @package RM\Standard\Message\Format
 * @author  h1karo <h1karo@outlook.com>
 */
interface MessageFormatterInterface
{
    /**
     * Encodes the message into some format.
     *
     * @param array $message
     *
     * @return string
     * @throws FormatterException
     */
    public function encode(array $message): string;

    /**
     * Decodes the message from some format.
     *
     * @param string $message
     *
     * @return array
     * @throws FormatterException
     */
    public function decode(string $message): array;
}