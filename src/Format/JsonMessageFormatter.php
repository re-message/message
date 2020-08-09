<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Format;

use RM\Standard\Message\Exception\FormatterException;
use Webmozart\Json\JsonDecoder;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\ValidationFailedException;

/**
 * Class JsonMessageFormatter
 *
 * @package RM\Standard\Message
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class JsonMessageFormatter implements MessageFormatterInterface
{
    private JsonEncoder $encoder;
    private JsonDecoder $decoder;

    public function __construct()
    {
        $this->encoder = new JsonEncoder();
        $this->decoder = new JsonDecoder();
        $this->decoder->setObjectDecoding(JsonDecoder::ASSOC_ARRAY);
    }

    /**
     * @inheritDoc
     */
    public function encode(array $message): string
    {
        try {
            return $this->encoder->encode($message);
        } catch (ValidationFailedException $e) {
            throw new FormatterException(sprintf('Unable to encode passed message into JSON: %s', $e->getMessage()));
        }
    }

    /**
     * @inheritDoc
     */
    public function decode(string $message): array
    {
        try {
            return $this->decoder->decode($message);
        } catch (ValidationFailedException $e) {
            throw new FormatterException(sprintf('Unable to decode passed message from JSON: %s', $e->getMessage()));
        }
    }
}
