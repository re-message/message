<?php

/*
 * This file is part of Message Standard.
 *
 * (c) 2018-present Re Message
 *     Oleg Kozlov <h1karo@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://dev.remessage.ru/packages/message
 * https://github.com/re-message/message
 */

use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use RM\Style\RuleSet\Config;
use RM\Style\RuleSet\Header;

$finder = Finder::create()
    ->in(__DIR__)
    ->append([__FILE__])
    ->exclude('vendor')
;

$header = new Header()
    ->setNamespace('Re Message')
    ->setProjectName('message')
    ->setProjectTitle('Message Standard')
    ->withAuthor('Oleg Kozlov', 'h1karo@outlook.com')
;

return new Config()
    ->setHeader($header)
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect())
;
