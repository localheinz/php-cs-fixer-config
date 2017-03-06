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

    public function testFromRulesThrowsRuntimeExceptionIfCurrentPhpVersionIsLessThanTargetPhpVersion()
    {
        $targetPhpVersion = PHP_VERSION_ID + 1;

        $ruleSet = $this->createRuleSetMock();

        $ruleSet
            ->expects($this->never())
            ->method('name');

        $ruleSet
            ->expects($this->never())
            ->method('rules');

        $ruleSet
            ->expects($this->atLeastOnce())
            ->method('targetPhpVersion')
            ->willReturn($targetPhpVersion);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(\sprintf(
            'Current PHP version "%s is less than targeted PHP version "%s".',
            PHP_VERSION_ID,
            $targetPhpVersion
        ));

        Config\Factory::fromRuleSet($ruleSet);
    }

    /**
     * @dataProvider providerTargetPhpVersion
     *
     * @param $targetPhpVersion
     */
    public function testFromRulesCreatesConfig($targetPhpVersion)
    {
        $name = 'foobarbaz';

        $rules = [
            'foo' => true,
            'bar' => [
                'baz',
            ],
        ];

        $ruleSet = $this->createRuleSetMock();

        $ruleSet
            ->expects($this->once())
            ->method('name')
            ->willReturn($name);

        $ruleSet
            ->expects($this->once())
            ->method('rules')
            ->willReturn($rules);

        $ruleSet
            ->expects($this->atLeastOnce())
            ->method('targetPhpVersion')
            ->willReturn($targetPhpVersion);

        $config = Config\Factory::fromRuleSet($ruleSet);

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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Config\RuleSet
     */
    private function createRuleSetMock()
    {
        return $this->createMock(Config\RuleSet::class);
    }
}
