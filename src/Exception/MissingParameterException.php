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

use Throwable;

/**
 * Class MissingParameterException
 *
 * @package RM\Standard\Message\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class MissingParameterException extends ExplanatoryException
{
    private const LINK_FORMAT = 'https://dev.relmsg.ru/api/action/%s';

    public function __construct(string $parameter, string $action, Throwable $previous = null)
    {
        $message = sprintf('Parameter with name `%s` for action `%s` does not exist.', $parameter, $action);
        $link = sprintf(self::LINK_FORMAT, $action);
        parent::__construct($message, $parameter, null, $link, $previous);
    }
}