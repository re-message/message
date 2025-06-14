<?php

/*
 * This file is part of Message Standard.
 *
 * (c) 2018-present Re Message
 *     Oleg Kozlov <h1karo@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://dev.remessage.ru/packages/message
 * https://github.com/re-message/message
 */

namespace RM\Standard\Message\Format;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
readonly class JsonMessageFormatter extends SymfonySerializerFormatter
{
    public function __construct(DecoderInterface&EncoderInterface $encoder = new JsonEncoder())
    {
        parent::__construct($encoder, JsonEncoder::FORMAT);
    }
}
