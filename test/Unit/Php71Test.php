<?php

/**
 * Copyright (c) 2017 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config\Test\Unit;

use Localheinz\PhpCsFixer\Config\Php71;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet;
use PHPUnit\Framework;

final class Php71Test extends Framework\TestCase
{
    public function testIsFinal()
    {
        $reflection = new \ReflectionClass(Php71::class);

        $this->assertTrue($reflection->isFinal());
    }

    public function testImplementsConfigInterface()
    {
        $reflection = new \ReflectionClass(Php71::class);

        $this->assertTrue($reflection->implementsInterface(ConfigInterface::class));
    }

    public function testDefaults()
    {
        $config = new Php71();

        $this->assertSame('localheinz (PHP 7.1)', $config->getName());
        $this->assertTrue($config->getRiskyAllowed());
        $this->assertTrue($config->getUsingCache());
    }

    public function testHasRules()
    {
        $config = new Php71();

        $this->assertEquals($this->expectedRules(), $config->getRules());
    }

    public function testAllConfiguredRulesAreBuiltIn()
    {
        $fixersNotBuiltIn = \array_diff(
            $this->configuredFixers(),
            $this->builtInFixers()
        );

        $this->assertEmpty($fixersNotBuiltIn, \sprintf(
            'Failed to assert that fixers for the rules "%s" are built in',
            \implode('", "', $fixersNotBuiltIn)
        ));
    }

    public function testAllBuiltInRulesAreConfigured()
    {
        $fixersWithoutConfiguration = \array_diff(
            $this->builtInFixers(),
            $this->configuredFixers()
        );

        $this->assertEmpty($fixersWithoutConfiguration, \sprintf(
            'Failed to assert that built-in fixers for the rules "%s" are configured',
            \implode('", "', $fixersWithoutConfiguration)
        ));
    }

    /**
     * @dataProvider providerInvalidHeader
     *
     * @param $header
     */
    public function testConstructorRejectsInvalidHeader($header)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Php71($header);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidHeader()
    {
        $values = [
            'boolean-true' => true,
            'boolean-false' => false,
            'float' => 3.14,
            'integer' => 90001,
            'array' => [],
            'object' => new \stdClass(),
            'empty-string' => '',
            'string-with-spaces-only' => ' ',
            'string-with-line-feed-only' => "\n",
            'string-with-tab-only' => "\t",
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    public function testHeaderCommentFixerIsDisabledByDefault()
    {
        $config = new Php71();

        $rules = $config->getRules();

        $this->assertArrayHasKey('header_comment', $rules);
        $this->assertFalse($rules['header_comment']);
    }

    public function testHeaderCommentFixerIsEnabledIfHeaderProvided()
    {
        $header = 'foo';

        $config = new Php71($header);

        $rules = $config->getRules();

        $this->assertArrayHasKey('header_comment', $rules);

        $expected = [
            'commentType' => 'PHPDoc',
            'header' => $header,
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ];

        $this->assertSame($expected, $rules['header_comment']);
    }

    /**
     * @return string[]
     */
    private function builtInFixers()
    {
        static $builtInFixers;

        if (null === $builtInFixers) {
            $fixerFactory = FixerFactory::create();
            $fixerFactory->registerBuiltInFixers();

            $builtInFixers = \array_map(function (FixerInterface $fixer) {
                return $fixer->getName();
            }, $fixerFactory->getFixers());
        }

        return $builtInFixers;
    }

    /**
     * @return string[]
     */
    private function configuredFixers()
    {
        $config = new Php71();

        /**
         * RuleSet::create() removes disabled fixers, to let's just enable them to make sure they not removed.
         *
         * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/2361
         */
        $rules = \array_map(function () {
            return true;
        }, $config->getRules());

        return \array_keys(RuleSet::create($rules)->getRules());
    }

    /**
     * @return array
     */
    private function expectedRules()
    {
        return [
            '@PSR2' => true,
            'array_syntax' => [
                'syntax' => 'short',
            ],
            'binary_operator_spaces' => [
                'align_double_arrow' => false,
                'align_equals' => false,
            ],
            'blank_line_after_opening_tag' => true,
            'blank_line_before_return' => true,
            'cast_spaces' => true,
            'class_keyword_remove' => false,
            'combine_consecutive_unsets' => true,
            'concat_space' => [
                'spacing' => 'one',
            ],
            'declare_equal_normalize' => true,
            'declare_strict_types' => true,
            'dir_constant' => true,
            'ereg_to_preg' => true,
            'function_typehint_space' => true,
            'general_phpdoc_annotation_remove' => false,
            'hash_to_slash_comment' => true,
            'header_comment' => false,
            'heredoc_to_nowdoc' => true,
            'include' => true,
            'is_null' => [
                'use_yoda_style' => true,
            ],
            'linebreak_after_opening_tag' => true,
            'lowercase_cast' => true,
            'mb_str_functions' => true,
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
            'no_leading_import_slash' => true,
            'no_leading_namespace_whitespace' => true,
            'no_mixed_echo_print' => [
                'use' => 'echo',
            ],
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_multiline_whitespace_before_semicolons' => true,
            'no_php4_constructor' => false,
            'no_short_bool_cast' => true,
            'no_short_echo_tag' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_around_offset' => true,
            'no_trailing_comma_in_list_call' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_unneeded_control_parentheses' => true,
            'no_unreachable_default_argument_value' => true,
            'no_unused_imports' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'no_whitespace_before_comma_in_array' => true,
            'no_whitespace_in_blank_line' => true,
            'normalize_index_brace' => true,
            'not_operator_with_space' => false,
            'not_operator_with_successor_space' => false,
            'object_operator_without_whitespace' => true,
            'ordered_class_elements' => true,
            'ordered_imports' => true,
            'php_unit_construct' => true,
            'php_unit_dedicate_assert' => true,
            'php_unit_fqcn_annotation' => true,
            'php_unit_strict' => false,
            'phpdoc_add_missing_param_annotation' => [
                'only_untyped' => false,
            ],
            'phpdoc_align' => true,
            'phpdoc_annotation_without_dot' => true,
            'phpdoc_indent' => true,
            'phpdoc_inline_tag' => true,
            'phpdoc_no_access' => true,
            'phpdoc_no_alias_tag' => [
                'type' => 'var',
            ],
            'phpdoc_no_empty_return' => true,
            'phpdoc_no_package' => true,
            'phpdoc_no_useless_inheritdoc' => true,
            'phpdoc_return_self_reference' => true,
            'phpdoc_order' => true,
            'phpdoc_scalar' => true,
            'phpdoc_separation' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_summary' => true,
            'phpdoc_to_comment' => false,
            'phpdoc_trim' => true,
            'phpdoc_types' => true,
            'phpdoc_var_without_name' => true,
            'pow_to_exponentiation' => true,
            'pre_increment' => true,
            'protected_to_private' => true,
            'psr0' => false,
            'psr4' => true,
            'random_api_migration' => true,
            'return_type_declaration' => true,
            'self_accessor' => true,
            'semicolon_after_instruction' => true,
            'short_scalar_cast' => true,
            'silenced_deprecation_error' => false,
            'simplified_null_return' => false,
            'single_blank_line_before_namespace' => true,
            'single_quote' => true,
            'space_after_semicolon' => true,
            'standardize_not_equals' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'ternary_operator_spaces' => true,
            'ternary_to_null_coalescing' => true,
            'trailing_comma_in_multiline_array' => true,
            'trim_array_spaces' => true,
            'unary_operator_spaces' => true,
            'visibility_required' => [
                'const',
                'method',
                'property',
            ],
            'whitespace_after_comma_in_array' => true,
        ];
    }
}
