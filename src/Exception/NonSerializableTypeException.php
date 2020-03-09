<?php
/**
 * This file is a part of Relations Messenger API Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @link      https://gitlab.com/relmsg/message
 * @link      https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Exception;

/**
 * Class NonSerializableTypeException
 *
 * @package RM\Standard\Message\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class NonSerializableTypeException extends ExplanatoryException
{
    public function __construct($value)
    {
        $type = gettype($value);
        $message = sprintf('You cannot use this value type (%s) to send messages.', $type);
        parent::__construct($message, $value, 'Serialize your value.', null);
    }
}