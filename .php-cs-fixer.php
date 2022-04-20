<?php

$header = <<<'EOF'
This file is part of the hedeqiang/umeng.

(c) hedeqiang <laravel_code@163.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'header_comment' => array('header' => $header),
        'array_syntax' => array('syntax' => 'short'),
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'binary_operator_spaces' => [
            'operators' => ['=>' => 'align_single_space_minimal']
        ]
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
    ->setUsingCache(false);
