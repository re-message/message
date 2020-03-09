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
 * Class ActionNotFoundException
 *
 * @package RM\Standard\Message\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class ActionNotFoundException extends ExplanatoryException
{
    private const LINK = 'https://dev.relmsg.ru/api/actions';

    public function __construct(string $action)
    {
        $message = sprintf('Action with name `%s` does not exist.', $action);
        parent::__construct($message, $action, null, self::LINK);
    }
}