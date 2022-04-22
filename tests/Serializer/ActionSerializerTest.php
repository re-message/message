<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
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

/**
 * @internal
 * @coversDefaultClass \RM\Standard\Message\Serializer\ActionSerializer
 */
class ActionSerializerTest extends TestCase
{
    /**
     * @dataProvider providePositiveMessages
     * @covers       ::serialize
     */
    public function testSerialize(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
        $serialized = $serializer->serialize($message);

        self::assertIsString($serialized);
    }

    /**
     * @dataProvider providePositiveMessages
     * @covers       ::deserialize
     */
    public function testUnserializePositive(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
        $serialized = $serializer->serialize($message);
        $m = $serializer->deserialize($serialized);

        self::assertEquals($message->getType(), $m->getType());
        self::assertEquals($message->toArray(), $m->toArray());
    }

    /**
     * @dataProvider provideNegativeMessages
     * @covers       ::deserialize
     */
    public function testUnserializeNegative(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
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
