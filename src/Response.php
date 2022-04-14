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
 * @see MessageType::RESPONSE
 */
class Response implements IdentifiableMessageInterface
{
    private string|null $id;
    private array $content;

    public function __construct(array $content, string|null $id = null)
    {
        $this->id = $id;
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): MessageType
    {
        return MessageType::RESPONSE;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritdoc}
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
