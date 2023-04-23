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

namespace RM\Standard\Message\Serializer;

trigger_deprecation(
    'remessage/message',
    '2.3.0',
    '%s will be removed in 3.0. Please use %s instead',
    ChainMessageSerializer::class,
    DelegatingMessageSerializer::class,
);

/**
 * @deprecated please use {@see DelegatingMessageSerializer} instead
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ChainMessageSerializer extends DelegatingMessageSerializer
{
}
