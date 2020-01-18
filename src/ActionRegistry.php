<?php
/**
 * Relations Messenger API Message Standard
 *
 * @link      https://gitlab.com/relmsg/message
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 */

namespace RM\Standards\Message;

/**
 * Class ActionRegistry
 *
 * @package RM\Standards\Message
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