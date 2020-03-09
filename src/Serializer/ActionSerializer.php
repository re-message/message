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

namespace RM\Standard\Message\Serializer;

use RM\Standard\Message\Action;
use RM\Standard\Message\ActionRegistry;
use RM\Standard\Message\Exception\ActionNotFoundException;
use RM\Standard\Message\Exception\FormatterException;
use RM\Standard\Message\Exception\InvalidParameterException;
use RM\Standard\Message\Exception\NonSerializableTypeException;
use RM\Standard\Message\Exception\SerializerException;
use RM\Standard\Message\Exception\UnknownParameterException;
use RM\Standard\Message\Format\MessageFormatterInterface;
use RM\Standard\Message\MessageInterface;
use RM\Standard\Message\MessageType;

/**
 * Class ActionSerializer
 *
 * @package RM\Standard\Message\Serializer
 * @author  h1karo <h1karo@outlook.com>
 * @see     MessageType::ACTION
 */
class ActionSerializer extends AbstractMessageSerializer
{
    private ActionRegistry $registry;

    public function __construct(ActionRegistry $registry, MessageFormatterInterface $formatter = null)
    {
        parent::__construct($formatter);
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     *
     * @param string $message
     *
     * @return Action
     * @throws ActionNotFoundException
     * @throws FormatterException
     * @throws SerializerException
     * @throws InvalidParameterException
     * @throws UnknownParameterException
     * @throws NonSerializableTypeException
     */
    public function deserialize(string $message): MessageInterface
    {
        $array = $this->formatter->decode($message);
        if (!$this->supports($message)) {
            throw new SerializerException(sprintf('%s can not deserialize this message.', static::class));
        }

        $name = $array['name'];
        $parameters = $array['parameters'];

        if (!$this->registry->has($name)) {
            throw new ActionNotFoundException($name);
        }

        $class = $this->registry->get($name);

        /** @var Action $action */
        $action = new $class();
        $action->bindAll($parameters);

        $violations = $action->validateAll();
        if ($violations->count() > 0) {
            $violation = $violations->get(0);
            throw new InvalidParameterException($action::getName(), null, null, $violation);
        }

        return $action;
    }

    /**
     * @inheritDoc
     */
    protected function getSupportTypes(): array
    {
        return [MessageType::ACTION];
    }

    protected function getRequiredProperties(): array
    {
        return ['name', 'parameters'];
    }
}