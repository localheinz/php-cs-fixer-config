<?php

/**
 * Copyright (c) 2017 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config\Test\Unit\RuleSet;

use Localheinz\PhpCsFixer\Config;
use PhpCsFixer\Fixer;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet;
use PHPUnit\Framework;

abstract class AbstractRuleSetTestCase extends Framework\TestCase
{
    final public function testIsFinal()
    {
        $reflection = new \ReflectionClass($this->className());

        $this->assertTrue($reflection->isFinal());
    }

    final public function testImplementsRuleSetInterface()
    {
        $reflection = new \ReflectionClass($this->className());

        $this->assertTrue($reflection->implementsInterface(Config\RuleSet::class));
    }

    final public function testDefaults()
    {
        $ruleSet = $this->createRuleSet();

        $this->assertSame($this->name(), $ruleSet->name());
        $this->assertEquals($this->rules(), $ruleSet->rules());
    }

    final public function testAllConfiguredRulesAreBuiltIn()
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

    final public function testAllBuiltInRulesAreConfigured()
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
    final public function testConstructorRejectsInvalidHeader($header)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->createRuleSet($header);
    }

    /**
     * @return \Generator
     */
    final public function providerInvalidHeader()
    {
        $values = [
            'array' => [],
            'boolean-true' => true,
            'boolean-false' => false,
            'float' => 3.14,
            'integer' => 90001,
            'string-empty' => '',
            'string-with-line-feed-only' => "\n",
            'string-with-spaces-only' => ' ',
            'string-with-tab-only' => "\t",
            'object' => new \stdClass(),
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    final public function testHeaderCommentFixerIsDisabledByDefault()
    {
        $rules = $this->createRuleSet()->rules();

        $this->assertArrayHasKey('header_comment', $rules);
        $this->assertFalse($rules['header_comment']);
    }

    final public function testHeaderCommentFixerIsEnabledIfHeaderIsProvided()
    {
        $header = 'foo';

        $rules = $this->createRuleSet($header)->rules();

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
     * @return string
     */
    abstract protected function className();

    /**
     * @return array
     */
    abstract protected function rules();

    /**
     * @return string
     */
    abstract protected function name();

    /**
     * @param string $header
     *
     * @throws \InvalidArgumentException
     *
     * @return Config\RuleSet
     */
    final protected function createRuleSet($header = null)
    {
        $reflection = new \ReflectionClass($this->className());

        return $reflection->newInstance($header);
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

            $builtInFixers = \array_map(function (Fixer\FixerInterface $fixer) {
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
        /**
         * RuleSet::create() removes disabled fixers, to let's just enable them to make sure they not removed.
         *
         * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/2361
         */
        $rules = \array_map(function () {
            return true;
        }, $this->createRuleSet()->rules());

        return \array_keys(RuleSet::create($rules)->getRules());
    }
}
