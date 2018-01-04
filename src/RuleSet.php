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

interface RuleSet
{
    /**
     * Returns the name of the rule set.
     *
     * @return string
     */
    public function name();

    /**
     * Returns an array of rules along with their configuration.
     *
     * @return array
     */
    public function rules();

    /**
     * Returns the minimum required PHP version (PHP_VERSION_ID).
     *
     * @see http://php.net/manual/en/reserved.constants.php
     *
     * @return int
     */
    public function targetPhpVersion();
}
