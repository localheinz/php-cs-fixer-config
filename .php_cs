<?php

/**
 * Copyright (c) 2017 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/php-cs-fixer-config
 */
use Localheinz\PhpCsFixer\Config;

$header = <<<'EOF'
Copyright (c) 2017 Andreas Möller

For the full copyright and license information, please view
the LICENSE file that was distributed with this source code.

@see https://github.com/localheinz/php-cs-fixer-config
EOF;

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php56($header));

$config->getFinder()
    ->ignoreDotFiles(false)
    ->in(__DIR__)
    ->exclude([
        '.build',
        '.github',
        '.travis',
    ])
    ->name('.php_cs');

$directory = \getenv('TRAVIS') ? \getenv('HOME') : __DIR__;

$config->setCacheFile($directory . '/.build/php-cs-fixer/.php_cs.cache');

return $config;
