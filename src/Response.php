<?php
/**
 * Relations Messenger API Message Standard
 *
 * @link      https://gitlab.com/relmsg/message
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/message
 */

namespace RM\API\Message;

/**
 * Class Response
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class Response implements MessageInterface
{
    private $content;

    /**
     * Response constructor.
     *
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return MessageType::RESPONSE;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(): array
    {
        return [
            'type'    => $this->getType(),
            'content' => $this->content
        ];
    }

    /**
     * {@inheritDoc}
     * @throws ExplanatoryException
     */
    public static function unserialize(array $message)
    {
        if (!array_key_exists('content', $message)) {
            throw new ExplanatoryException("Any correct response message must have `content` property.", $message);
        }

        $content = $message['content'];
        return new self($content);
    }
}