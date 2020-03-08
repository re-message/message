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

namespace RM\Standard\Message\Serializer;

use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Format\JsonMessageFormatter;
use RM\Standard\Message\Format\MessageFormatterInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * Class AbstractMessageSerializer
 *
 * @package RM\Standard\Message\Serializer
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractMessageSerializer implements MessageSerializerInterface
{
    protected MessageFormatterInterface $formatter;

    public function __construct(MessageFormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?? new JsonMessageFormatter();
    }

    /**
     * @inheritDoc
     * @throws FormatterException
     */
    public function serialize(MessageInterface $message): string
    {
        return $this->formatter->encode($message->toArray());
    }

    /**
     * @inheritDoc
     * @throws FormatterException
     */
    public function supports($message): bool
    {
        if (!$message instanceof MessageInterface) {
            $array = $this->formatter->decode($message);
            $type = $array['type'];
        } else {
            $array = $message->toArray();
            $type = $message->getType();
        }

        if (!in_array($type, $this->getSupportTypes(), true)) {
            return false;
        }

        $diff = array_diff_key(array_flip($this->getRequiredProperties()), $array);
        return count($diff) === 0;
    }

    /**
     * List of message types supports by serializer.
     * Full message type list available as constants of class {@see MessageType}.
     *
     * @return array
     */
    abstract protected function getSupportTypes(): array;

    /**
     * List of required properties. If one of these properties does not exist,
     * {@see supports()} will return false.
     *
     * @return array
     */
    protected function getRequiredProperties(): array
    {
        return [];
    }
}