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

namespace RM\Standard\Message\Tests\Serializer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use RM\Standard\Message\Action;
use RM\Standard\Message\Error;
use RM\Standard\Message\Exception\Exception;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\Format\JsonMessageFormatter;
use RM\Standard\Message\Format\SymfonySerializerFormatter;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;
use RM\Standard\Message\Response;
use RM\Standard\Message\Serializer\AbstractMessageSerializer;
use RM\Standard\Message\Serializer\ActionSerializer;

/**
 * @internal
 */
#[CoversClass(ActionSerializer::class)]
#[UsesClass(Action::class)]
#[UsesClass(Error::class)]
#[UsesClass(Response::class)]
#[UsesClass(JsonMessageFormatter::class)]
#[UsesClass(SymfonySerializerFormatter::class)]
#[UsesClass(AbstractMessageSerializer::class)]
#[UsesClass(MessageType::class)]
#[UsesClass(Exception::class)]
class ActionSerializerTest extends TestCase
{
    #[Test]
    #[TestDox('Positive serialization')]
    #[DataProvider('providePositiveMessages')]
    public function serialize(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
        $serialized = $serializer->serialize($message);

        self::assertIsString($serialized);
    }

    #[Test]
    #[TestDox('Positive deserialization')]
    #[DataProvider('providePositiveMessages')]
    public function deserializePositive(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
        $serialized = $serializer->serialize($message);
        $m = $serializer->deserialize($serialized);

        self::assertEquals($message->getType(), $m->getType());
        self::assertEquals($message->toArray(), $m->toArray());
    }

    #[Test]
    #[TestDox('Negative deserialization')]
    #[DataProvider('provideNegativeMessages')]
    public function deserializeNegative(MessageInterface $message): void
    {
        $serializer = new ActionSerializer();
        $serialized = $serializer->serialize($message);

        $this->expectException(SerializerException::class);
        $serializer->deserialize($serialized);
    }

    public static function providePositiveMessages(): iterable
    {
        $action = new Action('some.action', ['var' => 'test']);

        yield [$action];

        $action = new Action('some.action', ['another' => 123]);

        yield [$action];
    }

    public static function provideNegativeMessages(): iterable
    {
        yield [new Response(['oof'])];

        yield [new Error(1, 'Oops i did it again')];
    }
}
