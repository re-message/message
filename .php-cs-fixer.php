<?php

$finder = PhpCsFixer\Finder::create()
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

$config = new PhpCsFixer\Config();
return $config
    ->setRules(
        [
            '@PSR12' => true,
            '@Symfony' => true,
            '@PhpCsFixer' => true,
            '@DoctrineAnnotation' => true,
            '@PHP80Migration:risky' => true,
            '@PHP81Migration' => true,
            'declare_strict_types' => false,
            'ordered_class_elements' => false,
            'no_superfluous_phpdoc_tags' => false,
            'strict_param' => true,
            'array_syntax' => ['syntax' => 'short'],
            'concat_space' => ['spacing' => 'one'],
            'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
            'phpdoc_tag_type' => [
                'tags' => ['inheritDoc' => 'annotation'],
            ],
            'phpdoc_tag_casing' => [
                'tags' => ['inheritDoc'],
            ],
            'header_comment' => [
                'header' => $header,
                'comment_type' => 'comment',
                'location' => 'after_open',
                'separate' => 'bottom',
            ],
        ]
    )
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
