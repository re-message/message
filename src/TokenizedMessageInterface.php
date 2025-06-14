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
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
interface TokenizedMessageInterface extends MessageInterface
{
    final public const string PROPERTY_TOKEN = 'token';

    /**
     * Returns the token to access the requested resource or null.
     */
    public function getToken(): ?string;
}
