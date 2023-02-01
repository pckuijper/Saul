<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        dirname(__FILE__, 3) . '/src',
        dirname(__FILE__, 3) . '/tests',
    ])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setCacheFile(dirname(__FILE__, 3) . '/var/cache/.php_cs.cache')
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'final_internal_class' => true,
        'global_namespace_import' => [
            'import_classes' => true, 'import_constants' => true, 'import_functions' => true,
        ],
        'heredoc_indentation' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'phpdoc_to_comment' => false,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_no_expectation_annotation' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_size_class' => ['group' => 'small'],
        'php_unit_test_annotation' => ['style' => 'annotation'],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
        ],
        'void_return' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
    ])
    ->setFinder($finder);
