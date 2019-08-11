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

use Webmozart\Json\JsonDecoder as JsonHelper;
use Webmozart\Json\ValidationFailedException;

/**
 * Class JsonMessageDecoder
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class JsonDecoder extends MessageDecoder
{
    protected $registry = [
        MessageType::ACTION => Action::class
    ];
    
    /**
     * {@inheritDoc}
     */
    protected function parse(string $message): ?array
    {
        try {
            $decoder = new JsonHelper();
            return $decoder->decode($message);
        } catch (ValidationFailedException $e) {
            return null;
        }
    }
}