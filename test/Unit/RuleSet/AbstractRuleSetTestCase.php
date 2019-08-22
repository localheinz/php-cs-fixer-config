<?php

declare(strict_types=1);

/**
 * Copyright (c) 2017 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config\Test\Unit\RuleSet;

use Localheinz\PhpCsFixer\Config;
use PhpCsFixer\Fixer;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet;
use PHPUnit\Framework;

/**
 * @internal
 */
abstract class AbstractRuleSetTestCase extends Framework\TestCase
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var int
     */
    protected $targetPhpVersion;

    final public function testIsFinal(): void
    {
        $reflection = new \ReflectionClass($this->className());

        self::assertTrue($reflection->isFinal());
    }

    final public function testImplementsRuleSetInterface(): void
    {
        $reflection = new \ReflectionClass($this->className());

        self::assertTrue($reflection->implementsInterface(Config\RuleSet::class));
    }

    final public function testDefaults(): void
    {
        $ruleSet = $this->createRuleSet();

        self::assertSame($this->name, $ruleSet->name());
        self::assertEquals($this->rules, $ruleSet->rules());
        self::assertEquals($this->targetPhpVersion, $ruleSet->targetPhpVersion());
    }

    final public function testAllConfiguredRulesAreBuiltIn(): void
    {
        $fixersNotBuiltIn = \array_diff(
            $this->configuredFixers(),
            $this->builtInFixers()
        );

        \sort($fixersNotBuiltIn);

        self::assertEmpty($fixersNotBuiltIn, \sprintf(
            'Failed to assert that fixers for the rules "%s" are built in',
            \implode('", "', $fixersNotBuiltIn)
        ));
    }

    final public function testAllBuiltInRulesAreConfigured(): void
    {
        $fixersWithoutConfiguration = \array_diff(
            $this->builtInFixers(),
            $this->configuredFixers()
        );

        \sort($fixersWithoutConfiguration);

        self::assertEmpty($fixersWithoutConfiguration, \sprintf(
            'Failed to assert that built-in fixers for the rules "%s" are configured',
            \implode('", "', $fixersWithoutConfiguration)
        ));
    }

    /**
     * @dataProvider providerInvalidHeader
     *
     * @param mixed $header
     */
    final public function testConstructorRejectsInvalidHeader($header): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Header needs to be specified as null or a string. Got "%s" instead.',
            \is_object($header) ? \get_class($header) : \gettype($header)
        ));

        $this->createRuleSet($header);
    }

    /**
     * @return \Generator
     */
    final public function providerInvalidHeader()
    {
        $values = [
            'array' => [],
            'boolean-false' => false,
            'boolean-true' => true,
            'float' => 3.14,
            'integer' => 90001,
            'object' => new \stdClass(),
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    final public function testHeaderCommentFixerIsDisabledByDefault(): void
    {
        $rules = $this->createRuleSet()->rules();

        self::assertArrayHasKey('header_comment', $rules);
        self::assertFalse($rules['header_comment']);
    }

    /**
     * @dataProvider providerValidHeader
     *
     * @param string $header
     */
    final public function testHeaderCommentFixerIsEnabledIfHeaderIsProvided($header): void
    {
        $rules = $this->createRuleSet($header)->rules();

        self::assertArrayHasKey('header_comment', $rules);

        $expected = [
            'comment_type' => 'PHPDoc',
            'header' => \trim($header),
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ];

        self::assertSame($expected, $rules['header_comment']);
    }

    /**
     * @return \Generator
     */
    final public function providerValidHeader()
    {
        $values = [
            'string-empty' => '',
            'string-not-empty' => 'foo',
            'string-with-line-feed-only' => "\n",
            'string-with-spaces-only' => ' ',
            'string-with-tab-only' => "\t",
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    /**
     * @dataProvider providerRuleNames
     *
     * @param array  $ruleNames
     * @param string $source
     */
    final public function testRulesAreSortedByName($source, $ruleNames): void
    {
        $sorted = $ruleNames;

        \sort($sorted);

        self::assertEquals($sorted, $ruleNames, \sprintf(
            'Failed to assert that the rules are sorted by name in %s',
            $source
        ));
    }

    /**
     * @return \Generator
     */
    final public function providerRuleNames()
    {
        $values = [
            'rule set' => $this->createRuleSet()->rules(),
            'test' => $this->rules,
        ];

        foreach ($values as $source => $rules) {
            yield [
                $source,
                \array_keys($rules),
            ];
        }
    }

    /**
     * @return string
     */
    final protected function className()
    {
        return \preg_replace(
            '/Test$/',
            '',
            \str_replace(
                '\Test\Unit',
                '',
                static::class
            )
        );
    }

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

            $builtInFixers = \array_map(static function (Fixer\FixerInterface $fixer) {
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
         * RuleSet::create() removes disabled fixers, to let's just enable them to make sure they are not removed.
         *
         * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/2361
         */
        $rules = \array_map(static function () {
            return true;
        }, $this->createRuleSet()->rules());

        return \array_keys(RuleSet::create($rules)->getRules());
    }
}
