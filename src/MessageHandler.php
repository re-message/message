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

interface MessageHandler
{
    /**
     * @param MessageInterface $message
     *
     * @return bool
     */
    public function handlePreEncode(MessageInterface $message): bool;

    /**
     * @param string $message
     *
     * @return bool
     */
    public function handlePostEncode(string $message): bool;

    /**
     * @param string $message
     *
     * @return bool
     */
    public function handlePreDecode(string $message): bool;

    /**
     * @param MessageInterface $message
     *
     * @return bool
     */
    public function handlePostDecode(MessageInterface $message): bool;
}