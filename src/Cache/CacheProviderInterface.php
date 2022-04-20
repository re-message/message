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

namespace RM\Standard\Message\Cache;

/**
 * @template T of mixed
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @deprecated since 2.1.2 and will be removed at 2.2.0.
 */
interface CacheProviderInterface
{
    /**
     * Checks key exist in cache.
     */
    public function has(string $key): bool;

    /**
     * Saves a value by key.
     *
     * @param T $value
     */
    public function set(string $key, mixed $value): void;

    /**
     * Saves a value by key.
     *
     * @return T
     */
    public function get(string $key): mixed;

    /**
     * Remove cache by key.
     */
    public function remove(string $key): void;

    /**
     * Clear all cache.
     */
    public function clear(): void;
}
