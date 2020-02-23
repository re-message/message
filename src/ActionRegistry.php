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
 * Class ActionRegistry
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
final class ActionRegistry
{
    /**
     * @var array list of registered actions in format name => class.
     */
    private static $actions = [];

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public static function set(string $key, $value): void
    {
        self::$actions[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public static function get(string $key): ?string
    {
        return self::$actions[$key] ?? null;
    }
}