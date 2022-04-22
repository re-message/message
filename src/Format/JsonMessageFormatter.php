<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Format;

use RM\Standard\Message\Exception\FormatterException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class JsonMessageFormatter implements MessageFormatterInterface
{
    private JsonEncoder $encoder;

    public function __construct()
    {
        $this->encoder = new JsonEncoder();
    }

    /**
     * @inheritDoc
     */
    public function encode(array $message): string
    {
        try {
            return $this->encoder->encode($message, JsonEncoder::FORMAT);
        } catch (UnexpectedValueException $e) {
            throw new FormatterException(sprintf('Unable to encode passed message into JSON: %s', $e->getMessage()));
        }
    }

    /**
     * @inheritDoc
     */
    public function decode(string $message): array
    {
        try {
            return $this->encoder->decode($message, JsonEncoder::FORMAT);
        } catch (UnexpectedValueException $e) {
            throw new FormatterException(sprintf('Unable to decode passed message from JSON: %s', $e->getMessage()));
        }
    }
}
