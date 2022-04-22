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

namespace RM\Standard\Message;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 *
 * @see MessageType::RESPONSE
 */
class Response implements IdentifiableMessageInterface
{
    public function __construct(
        private readonly array $content,
        private readonly string|null $id = null
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getType(): MessageType
    {
        return MessageType::RESPONSE;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string|null
    {
        return $this->id;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType()->value,
            'content' => $this->getContent(),
        ];

        $notNull = static fn (mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
