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

use Webmozart\Json\JsonDecoder;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\ValidationFailedException;

/**
 * Class JsonMessageDecoder
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class JsonFormatter extends MessageFormatter
{
    protected array $registry = [
        MessageType::ACTION => Action::class,
        MessageType::RESPONSE => Response::class
    ];

    /**
     * {@inheritDoc}
     */
    protected function implode(array $message): ?string
    {
        try {
            $encoder = new JsonEncoder;
            return $encoder->encode($message);
        } catch (ValidationFailedException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function explode(string $message): ?array
    {
        try {
            $decoder = new JsonDecoder;
            return $decoder->decode($message);
        } catch (ValidationFailedException $e) {
            return null;
        }
    }
}