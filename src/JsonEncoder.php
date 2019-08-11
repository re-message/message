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

use Webmozart\Json\JsonEncoder as JsonHelper;
use Webmozart\Json\ValidationFailedException;

/**
 * Class JsonMessageEncoder
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class JsonEncoder extends MessageEncoder
{
    protected $registry = [
        MessageType::ACTION => Action::class
    ];
    
    /**
     * {@inheritDoc}
     */
    protected function parse(array $message): ?string
    {
        try {
            $encoder = new JsonHelper;
            return $encoder->encode($message);
        } catch (ValidationFailedException $e) {
            return null;
        }
    }
}