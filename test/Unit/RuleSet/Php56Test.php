<?php

/**
 * Copyright (c) 2017 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config\Test\Unit\RuleSet;

final class Php56Test extends AbstractRuleSetTestCase
{
    protected $name = 'localheinz (PHP 5.6)';

    protected $rules = [
        '@PSR2' => true,
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'blank_line_after_opening_tag' => true,
        'blank_line_before_return' => false,
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'continue',
                'declare',
                'do',
                'for',
                'foreach',
                'if',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
            ],
        ],
        'cast_spaces' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method',
                'property',
            ],
        ],
        'class_keyword_remove' => false,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_typehint' => false,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'declare_equal_normalize' => true,
        'declare_strict_types' => false,
        'dir_constant' => true,
        'doctrine_annotation_array_assignment' => true,
        'doctrine_annotation_braces' => [
            'syntax' => 'without_braces',
        ],
        'doctrine_annotation_indentation' => true,
        'doctrine_annotation_spaces' => true,
        'ereg_to_preg' => true,
        'escape_implicit_backslashes' => true,
        'explicit_indirect_variable' => false,
        'explicit_string_variable' => true,
        'final_internal_class' => true,
        'function_to_constant' => true,
        'function_typehint_space' => true,
        'general_phpdoc_annotation_remove' => false,
        'hash_to_slash_comment' => true,
        'header_comment' => false,
        'heredoc_to_nowdoc' => true,
        'include' => true,
        'increment_style' => [
            'style' => 'pre',
        ],
        'is_null' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => false,
        'lowercase_cast' => true,
        'magic_constant_casing' => true,
        'mb_str_functions' => true,
        'method_argument_space' => [
            'ensure_fully_multiline' => true,
            'keep_multiple_spaces_after_comma' => false,
        ],
        'method_chaining_indentation' => true,
        'method_separation' => true,
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'native_function_invocation' => true,
        'new_with_braces' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_blank_lines_before_namespace' => false,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_consecutive_blank_lines' => [
            'break',
            'continue',
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'throw',
            'use',
            'useTrait',
        ],
        'no_homoglyph_names' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_null_property_initialization' => true,
        'no_php4_constructor' => false,
        'no_short_bool_cast' => true,
        'no_short_echo_tag' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'non_printable_character' => true,
        'normalize_index_brace' => true,
        'not_operator_with_space' => false,
        'not_operator_with_successor_space' => false,
        'object_operator_without_whitespace' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_expectation' => [
            'target' => 'newest',
        ],
        'php_unit_fqcn_annotation' => true,
        'php_unit_mock' => true,
        'php_unit_namespaced' => [
            'target' => '5.7',
        ],
        'php_unit_no_expectation_annotation' => [
            'target' => 'newest',
            'use_class_const' => true,
        ],
        'php_unit_strict' => false,
        'php_unit_test_annotation' => false,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false,
        ],
        'phpdoc_align' => true,
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,

        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_first',
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_var_without_name' => true,
        'pow_to_exponentiation' => true,
        'pre_increment' => false,
        'protected_to_private' => true,
        'psr0' => false,
        'psr4' => true,
        'random_api_migration' => true,
        'return_type_declaration' => true,
        'self_accessor' => true,
        'semicolon_after_instruction' => true,
        'short_scalar_cast' => true,
        'silenced_deprecation_error' => false,
        'simplified_null_return' => true,
        'single_blank_line_before_namespace' => true,
        'single_line_comment_style' => false,
        'single_quote' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'static_lambda' => false,
        'strict_comparison' => true,
        'strict_param' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => false,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'visibility_required' => [
            'method',
            'property',
        ],
        'void_return' => false,
        'whitespace_after_comma_in_array' => true,
        'yoda_style' => [
            'equal' => true,
            'identical' => true,
            'less_and_greater' => true,
        ],
    ];

    protected $targetPhpVersion = 50600;
}
