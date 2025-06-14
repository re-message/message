<?php

/*
 * This file is part of Message Standard.
 *
 * (c) 2018-present Re Message
 *     Oleg Kozlov <h1karo@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://dev.remessage.ru/packages/message
 * https://github.com/re-message/message
 */

namespace RM\Standard\Message\Format;

use Override;
use RM\Standard\Message\Exception\FormatterException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
readonly class SymfonySerializerFormatter implements MessageFormatterInterface
{
    public function __construct(
        private DecoderInterface&EncoderInterface $encoder,
        private string $format,
    ) {}

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
