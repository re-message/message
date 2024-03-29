<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2023 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Serializer;

use Override;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\Format\JsonMessageFormatter;
use RM\Standard\Message\Format\MessageFormatterInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
abstract readonly class AbstractMessageSerializer implements MessageSerializerInterface
{
    protected MessageFormatterInterface $formatter;

    public function __construct(MessageFormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?? new JsonMessageFormatter();
    }

    /**
     * @throws FormatterException
     */
    #[Override]
    public function serialize(MessageInterface $message): string
    {
        return $this->formatter->encode($message->toArray());
    }

    #[Override]
    public function supports(MessageInterface|string $message): bool
    {
        try {
            $array = $this->convertToArray($message);
            if (!array_key_exists(MessageInterface::PROPERTY_TYPE, $array)) {
                return false;
            }

            $type = MessageType::tryFrom($array[MessageInterface::PROPERTY_TYPE]);
            if (null === $type) {
                return false;
            }

            if (!in_array($type, $this->getSupportTypes(), true)) {
                return false;
            }

            $diff = array_diff_key(array_flip($this->getRequiredProperties()), $array);

            return 0 === count($diff);
        } catch (FormatterException) {
            return false;
        }
    }

    /**
     * @throws FormatterException
     */
    private function convertToArray(MessageInterface|string $message): array
    {
        if ($message instanceof MessageInterface) {
            return $message->toArray();
        }

        return $this->formatter->decode($message);
    }

    /**
     * List of message types supports by serializer.
     * Full message type list available as constants of class {@see MessageType}.
     *
     * @return MessageType[]
     */
    abstract protected function getSupportTypes(): array;

    /**
     * List of required properties. If one of these properties does not exist,
     * {@see supports()} will return false.
     */
    protected function getRequiredProperties(): array
    {
        return [];
    }

    /**
     * @throws SerializerException
     */
    protected function throwException(): never
    {
        $message = sprintf('%s can not deserialize this message.', static::class);

        throw new SerializerException($message);
    }
}
