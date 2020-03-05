<?php
/**
 * This file is a part of Relations Messenger API Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @link      https://gitlab.com/relmsg/message
 * @link      https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message;

/**
 * Class Message
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
interface MessageInterface
{
    /**
     * Type of the message
     *
     * @return string
     * @see MessageType
     */
    public function getType(): string;

    /**
     * Converts message into array.
     *
     * @return array
     */
    public function toArray(): array;
}