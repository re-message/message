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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Action is a read-only representation.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see MessageType::ACTION
 */
class Action implements ActionInterface
{
    private readonly Collection $parameters;

    public function __construct(
        private readonly string $name,
        array $parameters = [],
        private readonly string|null $id = null
    ) {
        $this->parameters = new ArrayCollection($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): string|null
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    final public function getType(): MessageType
    {
        return MessageType::ACTION;
    }

    /**
     * {@inheritDoc}
     */
    public function hasParameter(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(string $name): mixed
    {
        return $this->parameters->get($name);
    }

    /**
     * {@inheritDoc}
     */
    public function hasValue(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    /**
     * {@inheritdoc}
     */
    final public function toArray(): array
    {
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType()->value,
            'name' => $this->getName(),
            'parameters' => $this->parameters->toArray(),
        ];

        $notNull = static fn (mixed $value) => null !== $value;

        return array_filter($array, $notNull);
    }
}
