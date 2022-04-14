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

namespace RM\Standard\Message;

/**
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see MessageType::ERROR
 */
class Error implements MessageInterface
{
    private int $code;
    private string $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    final public function toArray(): array
    {
        return [
            'type' => $this->getType()->value,
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];
    }
}
