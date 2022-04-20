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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @template T of mixed
 * @template-implements CacheProviderInterface<T>
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @deprecated since 2.1.2 and will be removed at 2.2.0.
 */
class RuntimeCacheProvider implements CacheProviderInterface
{
    /**
     * @var Collection<string, T>
     */
    private readonly Collection $cache;

    public function __construct()
    {
        $this->cache = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return $this->cache->containsKey($key);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): void
    {
        $this->cache->set($key, $value);
    }

    /**
     * @inheritDoc
     */
    public function get(string $key): mixed
    {
        return $this->cache->get($key);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key): void
    {
        $this->cache->remove($key);
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->cache->clear();
    }
}
