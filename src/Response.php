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
 * @author Oleg Kozlov <h1karo@remessage.ru>
 *
 * @see MessageType::RESPONSE
 */
readonly class Response implements IdentifiableMessageInterface
{
    final public const string PROPERTY_CONTENT = 'content';

    public function __construct(
        private array $content,
        private ?string $id = null,
    ) {}

    #[Override]
    final public function getType(): MessageType
    {
        return MessageType::RESPONSE;
    }

    #[Override]
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    #[Override]
    final public function toArray(): array
    {
        $array = [
            self::PROPERTY_ID => $this->getId(),
            self::PROPERTY_TYPE => $this->getType()->toString(),
            self::PROPERTY_CONTENT => $this->getContent(),
        ];

        $notNull = static fn(mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
