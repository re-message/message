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

namespace RM\Standards\Message;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidatableMessageInterface extends MessageInterface
{
    /**
     * Checks all the parameters values for compliance with they constraints.
     * Returns list of violations. If the list is empty validate succeeded.
     *
     * @return ConstraintViolationListInterface
     * @see ValidatorInterface::validate()
     */
    public function validateAll(): ConstraintViolationListInterface;

    /**
     * Checks the  value for compliance with parameter constraints.
     * Returns list of violations. If the list is empty validate succeeded.
     *
     * @param string $parameter
     * @param mixed  $value
     *
     * @return ConstraintViolationListInterface
     * @see ValidatorInterface::validate()
     */
    public function validateValue(string $parameter, $value): ConstraintViolationListInterface;

    /**
     * Checks the current parameter value for compliance with him constraints.
     * Returns list of violations. If the list is empty validate succeeded.
     *
     * @param string $parameter
     *
     * @return ConstraintViolationListInterface
     * @see ValidatorInterface::validate()
     */
    public function validateParameter(string $parameter): ConstraintViolationListInterface;
}