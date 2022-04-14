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
 * @see MessageType::ACTION
 */
interface ActionInterface extends IdentifiableMessageInterface, TokenizedMessageInterface
{
    /**
     * The unique name of action.
     *
     * @see https://dev.relmsg.ru/api/actions
     */
    public function getName(): string;

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
