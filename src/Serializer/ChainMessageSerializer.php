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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RM\Standard\Message\MessageInterface;

/**
 * Class ChainMessageSerializer
 *
 * @package RM\Standard\Message\Serializer
 * @author  h1karo <h1karo@outlook.com>
 */
class ChainMessageSerializer implements MessageSerializerInterface
{
    /**
     * @var MessageSerializerInterface[]|Collection
     */
    protected Collection $serializers;

    /**
     * ChainMessageSerializer constructor.
     *
     * @param MessageSerializerInterface[] $serializers
     */
    public function __construct(array $serializers = [])
    {
        $this->serializers = new ArrayCollection($serializers);
    }

    public function pushSerializer(MessageSerializerInterface $serializer): void
    {
        $this->serializers->add($serializer);
    }

    /**
     * @inheritDoc
     * @throws SerializerException
     */
    public function serialize(MessageInterface $message): string
    {
        return $this->getMessageSerializer($message)->serialize($message);
    }

    /**
     * @inheritDoc
     * @throws SerializerException
     */
    public function deserialize(string $message): MessageInterface
    {
        return $this->getMessageSerializer($message)->deserialize($message);
    }

    /**
     * @inheritDoc
     */
    public function supports($message): bool
    {
        try {
            return $this->getMessageSerializer($message) !== null;
        } catch (SerializerException $e) {
            return false;
        }
    }

    /**
     * @param MessageInterface|string $message
     *
     * @return MessageSerializerInterface
     * @throws SerializerException
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