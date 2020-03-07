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

namespace RM\Standard\Message\Tests\Stubs;

use RM\Standard\Message\Action;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class SomeAction
 *
 * @package RM\Standard\Message\Tests\Stubs
 * @author  h1karo <h1karo@outlook.com>
 */
class SomeAction extends Action
{
    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return 'some.action';
    }

    /**
     * @inheritDoc
     */
    protected function getConstraints(): array
    {
        return [
            'var' => [
                new Required(),
                new Type('string')
            ],
            'another' => [
                new Type('int')
            ]
        ];
    }
}