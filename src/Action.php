<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
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
 * Class Action.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see     MessageType::ACTION
 */
class Action implements ActionInterface
{
    private string $name;
    private Collection $parameters;

    public function __construct(string $name, array $parameters = [])
    {
        $this->name = $name;
        $this->parameters = new ArrayCollection($parameters);
    }

    /**
     * The unique name of action.
     *
     * @return string
     *
     * @see https://dev.relmsg.ru/api/actions
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    final public function getType(): string
    {
        return MessageType::ACTION;
    }

    /**
     * Checks the existence of parameter by name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool
    {
        return $this->parameters->containsKey($name);
    }

    /**
     * Returns the current parameter value or or null.
     *
     * @param string $name
     *
     * @return null|mixed
     */
    public function getValue(string $name)
    {
        return $this->parameters->get($name);
    }

    /**
     * Checks the existence of value for parameter.
     *
     * @param string $name
     *
     * @return bool
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
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'parameters' => $this->parameters->toArray(),
        ];
    }
}
