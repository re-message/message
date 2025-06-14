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

/**
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface ActionInterface extends IdentifiableMessageInterface, TokenizedMessageInterface
{
    final public const string PROPERTY_NAME = 'name';
    final public const string PROPERTY_PARAMETERS = 'parameters';

    /**
     * The unique name of action.
     *
     * @see https://dev.remessage.ru/api/actions
     */
    public function getName(): string;

    /**
     * Returns the parameters of the action.
     *
     * @return array<string, mixed>
     */
    public function getParameters(): array;

    /**
     * Checks the existence of parameter by name.
     */
    public function hasParameter(string $name): bool;

    /**
     * Returns the current parameter value or the default value or null.
     */
    public function getValue(string $name): mixed;

    /**
     * Checks the existence of value or default value for parameter.
     */
    public function hasValue(string $name): bool;
}
