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
     * @return Config
     */
    public static function fromRuleSet(RuleSet $rules)
    {
        $config = new Config($rules->name());

        $config->setRiskyAllowed(true);
        $config->setRules($rules->rules());

        return $config;
    }
}
