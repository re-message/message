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
use RM\Standard\Message\IdentifiableMessageInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;
use RM\Standard\Message\Response;

/**
 * @readonly
 *
 * @see MessageType::RESPONSE
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ResponseSerializer extends AbstractMessageSerializer
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

        $content = $array[Response::PROPERTY_CONTENT];
        $id = $array[IdentifiableMessageInterface::PROPERTY_ID] ?? null;

        return new Response($content, $id);
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getSupportTypes(): array
    {
        return [MessageType::RESPONSE];
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getRequiredProperties(): array
    {
        return [Response::PROPERTY_CONTENT];
    }
}
