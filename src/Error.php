<?php
/**
 * This file is a part of Relations Messenger API Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @link      https://gitlab.com/relmsg/message
 * @link      https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message;

/**
 * Class Error
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
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
     * @inheritDoc
     */
    public function getType(): string
    {
        return MessageType::ERROR;
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}