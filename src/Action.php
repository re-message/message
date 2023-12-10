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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Override;

/**
 * Class Action is a read-only representation of Action message.
 *
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
readonly class Action implements ActionInterface
{
    private Collection $parameters;

    public function __construct(
        private string $name,
        array $parameters = [],
        private string|null $id = null,
        private string|null $token = null
    ) {
        $this->parameters = new ArrayCollection($parameters);
    }

    #[Override]
    final public function getType(): MessageType
    {
        return MessageType::ACTION;
    }

    #[Override]
    public function getId(): string|null
    {
        return $this->id;
    }

    #[Override]
    public function getName(): string
    {
        return $this->name;
    }

    #[Override]
    public function hasParameter(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    #[Override]
    public function getValue(string $name): mixed
    {
        return $this->parameters->get($name);
    }

    #[Override]
    public function hasValue(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    #[Override]
    public function getToken(): string|null
    {
        return $this->token;
    }

    #[Override]
    final public function toArray(): array
    {
        $array = [
            self::PROPERTY_ID => $this->getId(),
            self::PROPERTY_TYPE => $this->getType()->toString(),
            self::PROPERTY_NAME => $this->getName(),
            self::PROPERTY_PARAMETERS => $this->parameters->toArray(),
            self::PROPERTY_TOKEN => $this->getToken(),
        ];

        $notNull = static fn (mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
