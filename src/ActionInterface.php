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
 * Interface ActionInterface.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see MessageType::ACTION
 */
interface ActionInterface extends IdentifiableMessageInterface
{
    /**
     * The unique name of action.
     *
     * @return string
     *
     * @see https://dev.relmsg.ru/api/actions
     */
    public function getName(): string;

    /**
     * Checks the existence of parameter by name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool;

    /**
     * Returns the current parameter value or the default value or null.
     *
     * @param string $name
     *
     * @return null|mixed
     */
    public function getValue(string $name): mixed;

    /**
     * Checks the existence of value or default value for parameter.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasValue(string $name): bool;
}
