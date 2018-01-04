<?php

/**
 * Copyright (c) 2017 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config\Test\Unit;

use Localheinz\PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PHPUnit\Framework;

final class FactoryTest extends Framework\TestCase
{
    public function testIsFinal()
    {
        $reflection = new \ReflectionClass(Config\Factory::class);

        $this->assertTrue($reflection->isFinal());
    }

    public function testFromRuleSetThrowsRuntimeExceptionIfCurrentPhpVersionIsLessThanTargetPhpVersion()
    {
        $targetPhpVersion = PHP_VERSION_ID + 1;

        $ruleSet = $this->prophesize(Config\RuleSet::class);

        $ruleSet
            ->name()
            ->shouldNotBeCalled();

        $ruleSet
            ->rules()
            ->shouldNotBeCalled();

        $ruleSet
            ->targetPhpVersion()
            ->shouldBeCalled()
            ->willReturn($targetPhpVersion);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(\sprintf(
            'Current PHP version "%s is less than targeted PHP version "%s".',
            PHP_VERSION_ID,
            $targetPhpVersion
        ));

        Config\Factory::fromRuleSet($ruleSet->reveal());
    }

    /**
     * @dataProvider providerTargetPhpVersion
     *
     * @param $targetPhpVersion
     */
    public function testFromRuleSetCreatesConfig($targetPhpVersion)
    {
        $name = 'foobarbaz';

        $rules = [
            'foo' => true,
            'bar' => [
                'baz',
            ],
        ];

        $ruleSet = $this->prophesize(Config\RuleSet::class);

        $ruleSet
            ->name()
            ->shouldBeCalled()
            ->willReturn($name);

        $ruleSet
            ->rules()
            ->shouldBeCalled()
            ->willReturn($rules);

        $ruleSet
            ->targetPhpVersion()
            ->shouldBeCalled()
            ->willReturn($targetPhpVersion);

        $config = Config\Factory::fromRuleSet($ruleSet->reveal());

        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertTrue($config->getUsingCache());
        $this->assertTrue($config->getRiskyAllowed());
        $this->assertSame($rules, $config->getRules());
    }

    /**
     * @return \Generator
     */
    public function providerTargetPhpVersion()
    {
        $values = [
            PHP_VERSION_ID - 1,
            PHP_VERSION_ID,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testFromRuleSetCreatesConfigWithOverrideRules()
    {
        $name = 'foobarbaz';

        $rules = [
            'foo' => true,
            'bar' => [
                'baz',
            ],
        ];

        $overrideRules = [
            'foo' => false,
        ];

        $ruleSet = $this->prophesize(Config\RuleSet::class);

        $ruleSet
            ->name()
            ->shouldBeCalled()
            ->willReturn($name);

        $ruleSet
            ->rules()
            ->shouldBeCalled()
            ->willReturn($rules);

        $ruleSet
            ->targetPhpVersion()
            ->shouldBeCalled()
            ->willReturn(PHP_VERSION_ID);

        $config = Config\Factory::fromRuleSet(
            $ruleSet->reveal(),
            $overrideRules
        );

        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertTrue($config->getUsingCache());
        $this->assertTrue($config->getRiskyAllowed());
        $this->assertSame(\array_merge($rules, $overrideRules), $config->getRules());
    }
}
