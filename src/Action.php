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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Action is a read-only representation of Action message.
 *
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class Action implements ActionInterface
{
    private readonly Collection $parameters;

    public function __construct(
        private readonly string $name,
        array $parameters = [],
        private readonly string|null $id = null,
        private readonly string|null $token = null
    ) {
        $this->parameters = new ArrayCollection($parameters);
    }

    /**
     * @inheritDoc
     */
    final public function getType(): MessageType
    {
        return MessageType::ACTION;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string|null
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function hasParameter(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    /**
     * @inheritDoc
     */
    public function getValue(string $name): mixed
    {
        return $this->parameters->get($name);
    }

    /**
     * @inheritDoc
     */
    public function hasValue(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    /**
     * @inheritDoc
     */
    public function getToken(): string|null
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType()->value,
            'name' => $this->getName(),
            'parameters' => $this->parameters->toArray(),
            'token' => $this->getToken(),
        ];

        $notNull = static fn (mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
