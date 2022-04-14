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

use RM\Standard\Message\Cache\CacheProviderInterface;
use RM\Standard\Message\Cache\RuntimeCacheProvider;

/**
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class CacheableMessageFormatter extends DecoratedMessageFormatter
{
    /**
     * @var CacheProviderInterface<int>
     */
    private readonly CacheProviderInterface $encoderCache;

    /**
     * @var CacheProviderInterface<array>
     */
    private readonly CacheProviderInterface $decoderCache;

    public function __construct(
        MessageFormatterInterface $formatter,
        CacheProviderInterface $encoderCache = new RuntimeCacheProvider(),
        CacheProviderInterface $decoderCache = new RuntimeCacheProvider(),
    ) {
        parent::__construct($formatter);

        $this->encoderCache = $encoderCache;
        $this->decoderCache = $decoderCache;
    }

    /**
     * @inheritDoc
     */
    public function encode(array $message): string
    {
        $key = $this->generateKeyFromArray($message);
        if ($this->encoderCache->has($key)) {
            return $this->encoderCache->get($key);
        }

        $encoded = parent::encode($message);
        $this->encoderCache->set($key, $encoded);
        $this->decoderCache->set($key, $message);

        return $encoded;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $message): array
    {
        $key = $this->generateKeyFromString($message);
        if ($this->decoderCache->has($key)) {
            return $this->decoderCache->get($key);
        }

        $decoded = parent::decode($message);
        $this->decoderCache->set($key, $decoded);
        $this->encoderCache->set($key, $message);

        return $decoded;
    }

    public function clear(): void
    {
        $this->encoderCache->clear();
        $this->decoderCache->clear();
    }

    protected function generateKeyFromArray(array $input): string
    {
        $stringInput = serialize($input);

        return $this->generateKeyFromString($stringInput);
    }

    protected function generateKeyFromString(string $input): string
    {
        return base64_encode($input);
    }
}
