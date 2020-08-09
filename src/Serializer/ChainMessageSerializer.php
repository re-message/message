<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Serializer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;

/**
 * Class ChainMessageSerializer.
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class ChainMessageSerializer implements MessageSerializerInterface
{
    /**
     * @var Collection|MessageSerializerInterface[]
     */
    protected Collection $serializers;

    /**
     * ChainMessageSerializer constructor.
     *
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
     * {@inheritdoc}
     *
     * @throws SerializerException
     */
    public function serialize(MessageInterface $message): string
    {
        return $this->getMessageSerializer($message)->serialize($message);
    }

    /**
     * {@inheritdoc}
     *
     * @throws SerializerException
     */
    public function deserialize(string $message): MessageInterface
    {
        return $this->getMessageSerializer($message)->deserialize($message);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($message): bool
    {
        try {
            return null !== $this->getMessageSerializer($message);
        } catch (SerializerException $e) {
            return false;
        }
    }

    /**
     * @param MessageInterface|string $message
     *
     * @throws SerializerException
     *
     * @return MessageSerializerInterface
     */
    protected function getMessageSerializer($message): MessageSerializerInterface
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->supports($message)) {
                return $serializer;
            }
        }

        throw new SerializerException('Serializer for passed message not found.');
    }
}
