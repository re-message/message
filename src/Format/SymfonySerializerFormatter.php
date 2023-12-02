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

use Override;
use RM\Standard\Message\Exception\FormatterException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * @readonly
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class SymfonySerializerFormatter implements MessageFormatterInterface
{
    public function __construct(
        private readonly EncoderInterface&DecoderInterface $encoder,
        private readonly string $format,
    ) {
    }

    #[Override]
    public function encode(array $message): string
    {
        try {
            return $this->encoder->encode($message, $this->format);
        } catch (UnexpectedValueException $e) {
            throw new FormatterException(sprintf('Unable to encode passed message into JSON: %s', $e->getMessage()));
        }
    }

    #[Override]
    public function decode(string $message): array
    {
        try {
            return $this->encoder->decode($message, $this->format);
        } catch (UnexpectedValueException $e) {
            throw new FormatterException(sprintf('Unable to decode passed message from JSON: %s', $e->getMessage()));
        }
    }
}
