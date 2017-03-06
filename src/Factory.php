<?php

/**
 * Copyright (c) 2017 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config;

use PhpCsFixer\Config;

final class Factory
{
    /**
     * @param RuleSet $rules
     *
     * @throws \RuntimeException
     *
     * @return Config
     */
    public static function fromRuleSet(RuleSet $rules)
    {
        if (PHP_VERSION_ID < $rules->targetPhpVersion()) {
            throw new \RuntimeException(\sprintf(
                'Current PHP version "%s is less than targeted PHP version "%s".',
                PHP_VERSION_ID,
                $rules->targetPhpVersion()
            ));
        }

        $config = new Config($rules->name());

        $config->setRiskyAllowed(true);
        $config->setRules($rules->rules());

        return $config;
    }
}
