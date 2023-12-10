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

namespace RM\Standard\Message;

use Override;

/**
 * @see MessageType::ERROR
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
readonly class Error implements MessageInterface
{
    /**
     * @final
     */
    public const PROPERTY_CODE = 'code';
    /**
     * @final
     */
    public const PROPERTY_MESSAGE = 'message';

    public function __construct(
        private int $code,
        private string $message,
    ) {}

    #[Override]
    public function getType(): MessageType
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
