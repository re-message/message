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

namespace RM\Standard\Message;

/**
 * Class Response
 *
 * @package RM\Standard\Message
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