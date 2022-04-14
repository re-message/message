<?php
/*
 * This file is a part of Relations Messenger Message Standard.
 * This package is a part of Relations Messenger.
 *
 * @see       https://github.com/relmsg/message
 * @see       https://dev.relmsg.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Message\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use RM\Standard\Message\Action;
use RM\Standard\Message\Error;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;
use RM\Standard\Message\Serializer\ActionSerializer;
use RM\Standard\Message\Serializer\MessageSerializerInterface;

/**
 * @internal
 * @coversNothing
 */
class ActionSerializerTest extends TestCase
{
    public function testConstructor(): MessageSerializerInterface
    {
        $serializer = new ActionSerializer();
        self::assertInstanceOf(ActionSerializer::class, $serializer);

        return $serializer;
    }

    /**
     * @dataProvider providePositiveMessages
     * @depends      testConstructor
     *
     * @param MessageInterface           $message
     * @param MessageSerializerInterface $serializer
     */
    public function testSerialize(MessageInterface $message, MessageSerializerInterface $serializer): void
    {
        $serialized = $serializer->serialize($message);
        self::assertIsString($serialized);
    }

    /**
     * @dataProvider providePositiveMessages
     * @depends      testConstructor
     *
     * @param MessageInterface           $message
     * @param MessageSerializerInterface $serializer
     */
    public function testUnserializePositive(MessageInterface $message, MessageSerializerInterface $serializer): void
    {
        $serialized = $serializer->serialize($message);
        $m = $serializer->deserialize($serialized);
        self::assertEquals($message->getType(), $m->getType());
        self::assertEquals($message->toArray(), $m->toArray());
    }

    /**
     * @dataProvider provideNegativeMessages
     * @depends      testConstructor
     *
     * @param MessageInterface           $message
     * @param MessageSerializerInterface $serializer
     */
    public function testUnserializeNegative(MessageInterface $message, MessageSerializerInterface $serializer): void
    {
        $serialized = $serializer->serialize($message);
        $this->expectException(SerializerException::class);
        $serializer->deserialize($serialized);
    }

    public function providePositiveMessages(): iterable
    {
        $action = new Action('some.action', ['var' => 'test']);

        yield [$action];

        $action = new Action('some.action', ['another' => 123]);

        yield [$action];
    }

    public function provideNegativeMessages(): iterable
    {
        yield [new Response(['oof'])];

        yield [new Error(1, 'Oops i did it again')];
    }
}
