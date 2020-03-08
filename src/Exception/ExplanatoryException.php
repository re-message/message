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

namespace RM\Standard\Message\Exception;

use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Class ExplanatoryException\Exception
 *
 * @package RM\Standard\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class ExplanatoryException extends Exception
{
    /**
     * A reason of exception, some data.
     *
     * @var mixed
     */
    private $reason;

    /**
     * A probably solution of this problem.
     *
     * @var string
     */
    private ?string $solution;

    /**
     * A link to solution and/or explanation.
     *
     * @var string
     */
    private ?string $link;

    public function __construct(
        string $message,
        $reason,
        string $solution = null,
        string $link = null,
        Throwable $previous = null
    ) {
        parent::__construct($message, $previous);
        $this->reason = $reason;
        $this->solution = $solution;
        $this->link = $link;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function getSolution(): ?string
    {
        return $this->solution;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function log(LoggerInterface $logger, $level): void
    {
        $logger->log(
            $level,
            $this->getMessage(),
            [
                'reason' => serialize($this->getReason()),
                'solution' => $this->getSolution() ?? 'none',
                'link' => $this->getLink() ?? 'none',
                'file' => $this->getFile(),
                'line' => $this->getLine()
            ]
        );
    }
}