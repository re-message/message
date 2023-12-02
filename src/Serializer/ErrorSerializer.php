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
use RM\Standard\Message\Error;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * @author Oleg Kozlov <h1karo@remessage.ru>
 *
 * @see MessageType::ERROR
 */
class ErrorSerializer extends AbstractMessageSerializer
{
    /**
     * @inheritDoc
     *
     * @throws FormatterException
     * @throws SerializerException
     */
    #[Override]
    public function deserialize(string $message): MessageInterface
    {
        if (!$this->supports($message)) {
            $this->throwException();
        }

        $array = $this->formatter->decode($message);

        $errorCode = $array[Error::PROPERTY_CODE];
        $errorMessage = $array[Error::PROPERTY_MESSAGE];

        return new Error($errorCode, $errorMessage);
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getSupportTypes(): array
    {
        return [MessageType::ERROR];
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getRequiredProperties(): array
    {
        return [Error::PROPERTY_CODE, Error::PROPERTY_MESSAGE];
    }
}
