<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        'binary_operator_spaces' => [
            'default' => 'at_least_single_space',
        ],
        'single_line_empty_body' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_between_import_groups' => true,
        'blank_lines_before_namespace' => true,
        'braces_position' => [
            'allow_single_line_empty_anonymous_classes' => true,
            'control_structures_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'functions_opening_brace' => 'next_line_unless_newline_at_signature_end'
        ],
        'class_definition' => [
            'inline_constructor_arguments' => false, // handled by method_argument_space fixer
            'space_before_parenthesis' => true, // defined in PSR12 ¶8. Anonymous Classes
        ],
        'compact_nullable_type_declaration' => true,
        'declare_equal_normalize' => true,
        'lowercase_cast' => true,
        'lowercase_static_reference' => true,
        'new_with_parentheses' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_leading_import_slash' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
            ],
        ],
        'ordered_imports' => [
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
            'sort_algorithm' => 'none',
        ],
        'return_type_declaration' => true,
        'short_scalar_cast' => true,
        'single_import_per_statement' => ['group_to_single_imports' => false],
        'single_trait_insert_per_statement' => true,
        'ternary_operator_spaces' => true,
        'unary_operator_spaces' => [
            'only_dec_inc' => true,
        ],
        'visibility_required' => true,
        'control_structure_continuation_position' => ['position' => 'next_line']
    ])
    ->setFinder($finder);
