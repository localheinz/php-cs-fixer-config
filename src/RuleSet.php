<?php

/**
 * Copyright (c) 2017 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/php-cs-fixer-config
 */

namespace Localheinz\PhpCsFixer\Config;

interface RuleSet
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return array
     */
    public function rules();

    /**
     * @return int
     */
    public function targetPhpVersion();
}
