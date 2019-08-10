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

use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Class ExplanatoryException
 *
 * @package RM\API\Message
 * @author  h1karo <h1karo@outlook.com>
 */
class ExplanatoryException extends Exception
{
    /**
     * @var mixed
     */
    private $reason;
    /**
     * @var string
     */
    private $solution;
    /**
     * @var string
     */
    private $link;
    
    /**
     * ExplanatoryException constructor.
     *
     * @param string         $message  is a basic exception message
     * @param mixed          $reason   is a reason of exception, some data
     * @param string         $solution a probably solution of this problem
     * @param string         $link     a link to solution and/or explanation
     * @param Throwable|null $previous
     */
    public function __construct(string $message, $reason, string $solution = null, string $link = null, Throwable $previous = null)
    {
        parent::__construct($message, $previous);
        $this->reason = $reason;
        $this->solution = $solution;
        $this->link = $link;
    }
    
    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }
    
    /**
     * @return string|null
     */
    public function getSolution(): ?string
    {
        return $this->solution;
    }
    
    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }
    
    /**
     * @param LoggerInterface $logger
     * @param mixed           $level
     */
    public function log(LoggerInterface $logger, $level)
    {
        $logger->log($level, $this->getMessage(), [
            'reason'   => serialize($this->getReason()),
            'solution' => $this->getSolution() ?? 'none',
            'link'     => $this->getLink() ?? 'none',
            'file'     => $this->getFile(),
            'line'     => $this->getLine()
        ]);
    }
}