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
 * @author Oleg Kozlov <h1karo@remessage.ru>
 *
 * @see MessageType::RESPONSE
 */
readonly class Response implements IdentifiableMessageInterface
{
    /**
     * @final
     */
    public const PROPERTY_CONTENT = 'content';

    public function __construct(
        private array $content,
        private string|null $id = null
    ) {
    }

    #[Override]
    public function getType(): MessageType
    {
        return MessageType::RESPONSE;
    }

    #[Override]
    public function getId(): string|null
    {
        return $this->id;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    #[Override]
    public function toArray(): array
    {
        $array = [
            self::PROPERTY_ID => $this->getId(),
            self::PROPERTY_TYPE => $this->getType()->toString(),
            self::PROPERTY_CONTENT => $this->getContent(),
        ];

        $notNull = static fn (mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
