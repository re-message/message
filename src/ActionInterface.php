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

/**
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface ActionInterface extends IdentifiableMessageInterface, TokenizedMessageInterface
{
    public const PROPERTY_NAME = 'name';
    public const PROPERTY_PARAMETERS = 'parameters';

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
