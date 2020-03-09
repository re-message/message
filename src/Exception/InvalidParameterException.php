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

use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class InvalidParameterException
 *
 * @package RM\Standard\Message\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class InvalidParameterException extends ExplanatoryException
{
    private const LINK_FORMAT = 'https://dev.relmsg.ru/api/action/%s#parameter-%s';

    private ConstraintViolationInterface $violation;

    public function __construct(string $action, string $parameter, $value, ConstraintViolationInterface $violation)
    {
        $link = sprintf(self::LINK_FORMAT, $action, $parameter);
        parent::__construct('This value does not satisfy the parameter constraint.', $value, null, $link);

        $this->violation = $violation;
    }

    public function getViolation(): ConstraintViolationInterface
    {
        return $this->violation;
    }
}