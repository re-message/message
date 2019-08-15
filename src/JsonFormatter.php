<?php
/**
 * Relations Messenger API Message Standard
 *
 * @link      https://gitlab.com/relmsg/message
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 */

namespace RM\API\Message;

use Webmozart\Json\JsonDecoder;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\ValidationFailedException;

/**
 * Class JsonMessageDecoder
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class JsonFormatter extends MessageFormatter
{
    protected $registry = [
        MessageType::ACTION   => Action::class,
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