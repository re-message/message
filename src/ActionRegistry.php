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

namespace RM\Standard\Message;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ActionRegistry
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
final class ActionRegistry
{
    private Collection $elements;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
    }

    public function set(string $name, string $class): void
    {
        $this->elements->set($name, $class);
    }

    public function get(string $name): ?string
    {
        return $this->elements->get($name);
    }

    public function has(string $name): bool
    {
        return $this->elements->containsKey($name);
    }
}