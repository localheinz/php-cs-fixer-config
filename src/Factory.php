<?php

/**
 * Copyright (c) 2017-2018 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config;

use PhpCsFixer\Config;

final class Factory
{
    /**
     * Creates a configuration based on a rule set.
     *
     * @param RuleSet $ruleSet
     * @param array   $overrideRules
     *
     * @throws \RuntimeException
     *
     * @return Config
     */
    public static function fromRuleSet(RuleSet $ruleSet, array $overrideRules = [])
    {
        if (\PHP_VERSION_ID < $ruleSet->targetPhpVersion()) {
            throw new \RuntimeException(\sprintf(
                'Current PHP version "%s is less than targeted PHP version "%s".',
                \PHP_VERSION_ID,
                $ruleSet->targetPhpVersion()
            ));
        }

        $config = new Config($ruleSet->name());

        $config->setRiskyAllowed(true);
        $config->setRules(\array_merge(
            $ruleSet->rules(),
            $overrideRules
        ));

        return $config;
    }
}
