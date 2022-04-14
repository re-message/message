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

namespace RM\Standard\Message\Serializer;

use RM\Standard\Message\Action;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 *
 * @see MessageType::ACTION
 */
class ActionSerializer extends AbstractMessageSerializer
{
    /**
     * {@inheritdoc}
     *
     * @throws FormatterException
     * @throws SerializerException
     *
     * @return Action
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

        return new Action($name, $parameters, $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportTypes(): array
    {
        return [MessageType::ACTION];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequiredProperties(): array
    {
        return ['name'];
    }
}
