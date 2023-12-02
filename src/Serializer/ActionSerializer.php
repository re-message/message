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
use RM\Standard\Message\Action;
use RM\Standard\Message\ActionInterface;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\IdentifiableMessageInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;
use RM\Standard\Message\TokenizedMessageInterface;

/**
 * @readonly
 *
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ActionSerializer extends AbstractMessageSerializer
{
    /**
     * @throws FormatterException
     * @throws SerializerException
     */
    #[Override]
    public function deserialize(string $message): Action
    {
        if (!$this->supports($message)) {
            $this->throwException();
        }

        $array = $this->formatter->decode($message);

        $name = $array[ActionInterface::PROPERTY_NAME];
        $parameters = $array[ActionInterface::PROPERTY_PARAMETERS] ?? [];
        $id = $array[IdentifiableMessageInterface::PROPERTY_ID] ?? null;
        $token = $array[TokenizedMessageInterface::PROPERTY_TOKEN] ?? null;

        return new Action($name, $parameters, $id, $token);
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getSupportTypes(): array
    {
        return [MessageType::ACTION];
    }

    /**
     * @inheritDoc
     */
    #[Override]
    protected function getRequiredProperties(): array
    {
        return [ActionInterface::PROPERTY_NAME];
    }
}
