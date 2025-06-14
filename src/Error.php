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

namespace RM\Standard\Message;

use Override;

/**
 * @see MessageType::ERROR
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
readonly class Error implements MessageInterface
{
    final public const string PROPERTY_CODE = 'code';
    final public const string PROPERTY_MESSAGE = 'message';

    public function __construct(
        private int $code,
        private string $message,
    ) {}

    #[Override]
    final public function getType(): MessageType
    {
        return MessageType::ERROR;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    #[Override]
    final public function toArray(): array
    {
        return [
            self::PROPERTY_TYPE => $this->getType()->toString(),
            self::PROPERTY_CODE => $this->getCode(),
            self::PROPERTY_MESSAGE => $this->getMessage(),
        ];
    }
}
