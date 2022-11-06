<?php
/*
 * This file is a part of Message Standard.
 * This package is a part of Re Message.
 *
 * @link      https://github.com/re-message/message
 * @link      https://dev.remessage.ru/packages/message
 * @copyright Copyright (c) 2018-2022 Re Message
 * @author    Oleg Kozlov <h1karo@remessage.ru>
 * @license   Apache License 2.0
 * @license   https://legal.remessage.ru/licenses/message
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PhpCsFixer\Finder;
use RM\Style\RuleSet\Config;

$finder = Finder::create()
    ->in(__DIR__)
    ->append([__FILE__])
    ->exclude('vendor')
    ->notPath('src/MessageType.php')
;

$namespace = 'Re Message';
$projectTitle = 'Message Standard';
$projectName = 'message';
$currentYear = date('Y');

$header = <<<EOF
    This file is a part of {$projectTitle}.
    This package is a part of {$namespace}.

    @link      https://github.com/re-message/{$projectName}
    @link      https://dev.remessage.ru/packages/{$projectName}
    @copyright Copyright (c) 2018-{$currentYear} {$namespace}
    @author    Oleg Kozlov <h1karo@remessage.ru>
    @license   Apache License 2.0
    @license   https://legal.remessage.ru/licenses/{$projectName}

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    EOF;

$config = new Config();

return $config
    ->setHeader($header)
    ->setFinder($finder)
;
