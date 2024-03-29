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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Override;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
final readonly class DelegatingMessageSerializer implements MessageSerializerInterface
{
    /**
     * @var Collection<MessageSerializerInterface>
     */
    private Collection $serializers;

    /**
     * @param MessageSerializerInterface[] $serializers
     */
    public function __construct(array $serializers = [])
    {
        $this->serializers = new ArrayCollection();

        foreach ($serializers as $serializer) {
            $this->pushSerializer($serializer);
        }
    }

    public function pushSerializer(MessageSerializerInterface $serializer): void
    {
        $this->serializers->add($serializer);
    }

    /**
     * @throws SerializerException
     */
    #[Override]
    public function serialize(MessageInterface $message): string
    {
        return $this->getMessageSerializer($message)->serialize($message);
    }

    /**
     * @throws SerializerException
     */
    #[Override]
    public function deserialize(string $message): MessageInterface
    {
        return $this->getMessageSerializer($message)->deserialize($message);
    }

    #[Override]
    public function supports(MessageInterface|string $message): bool
    {
        try {
            return null !== $this->getMessageSerializer($message);
        } catch (SerializerException) {
            return false;
        }
    }

    /**
     * @throws SerializerException
     */
    private function getMessageSerializer(MessageInterface|string $message): MessageSerializerInterface
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->supports($message)) {
                return $serializer;
            }
        }

        throw new SerializerException('Serializer for passed message not found.');
    }
}
