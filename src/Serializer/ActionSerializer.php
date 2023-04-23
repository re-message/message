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

use RM\Standard\Message\Action;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * @see MessageType::ACTION
 *
 * @author Oleg Kozlov <h1karo@remessage.ru>
 */
class ActionSerializer extends AbstractMessageSerializer
{
    /**
     * @inheritDoc
     *
     * @return Action
     *
     * @throws FormatterException
     * @throws SerializerException
     */
    public function deserialize(string $message): MessageInterface
    {
        if (!$this->supports($message)) {
            $this->throwException();
        }

        $array = $this->formatter->decode($message);

        $name = $array['name'];
        $parameters = $array['parameters'] ?? [];
        $id = $array['id'] ?? null;
        $token = $array['token'] ?? null;

        return new Action($name, $parameters, $id, $token);
    }

    /**
     * @inheritDoc
     */
    protected function getSupportTypes(): array
    {
        return [MessageType::ACTION];
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredProperties(): array
    {
        return ['name'];
    }
}
