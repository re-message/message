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

namespace RM\Standard\Message\Tests\Serializer;

use Generator;
use PHPUnit\Framework\TestCase;
use RM\Standard\Message\ActionRegistry;
use RM\Standard\Message\Error;
use RM\Standard\Message\ExplanatoryException;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\Response;
use RM\Standard\Message\Serializer\ActionSerializer;
use RM\Standard\Message\Serializer\MessageSerializerInterface;
use RM\Standard\Message\Serializer\SerializerException;
use RM\Standard\Message\Tests\Stubs\SomeAction;

class ActionSerializerTest extends TestCase
{
    public function testConstructor(): MessageSerializerInterface
    {
        $registry = new ActionRegistry();
        $registry->push(SomeAction::class);
        $serializer = new ActionSerializer($registry);
        $this->assertInstanceOf(ActionSerializer::class, $serializer);
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
        $this->assertIsString($serialized);
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
        $this->assertEquals($message->getType(), $m->getType());
        $this->assertEquals($message->toArray(), $m->toArray());
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

    /**
     * @return Generator
     * @throws ExplanatoryException
     */
    public function providePositiveMessages(): Generator
    {
        $action = new SomeAction();
        $action->bind('var', 'test');
        yield [$action];

        $action->bind('another', 123);
        yield [$action];
    }

    public function provideNegativeMessages(): Generator
    {
        yield [new Response(['oof'])];
        yield [new Error(1, 'Oops i did it again')];
    }
}
