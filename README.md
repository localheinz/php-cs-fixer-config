# php-cs-fixer-config

[![Build Status](https://travis-ci.org/localheinz/php-cs-fixer-config.svg?branch=master)](https://travis-ci.org/localheinz/php-cs-fixer-config)
[![Code Climate](https://codeclimate.com/github/localheinz/php-cs-fixer-config/badges/gpa.svg)](https://codeclimate.com/github/localheinz/php-cs-fixer-config)
[![Test Coverage](https://codeclimate.com/github/localheinz/php-cs-fixer-config/badges/coverage.svg)](https://codeclimate.com/github/localheinz/php-cs-fixer-config/coverage)
[![Issue Count](https://codeclimate.com/github/localheinz/php-cs-fixer-config/badges/issue_count.svg)](https://codeclimate.com/github/localheinz/php-cs-fixer-config)

As an alternative to [`refinery29/php-cs-fixer-config`](http://github.com/refinery29/php-cs-fixer-config),
this repository provides a configuration factory and multiple rule sets for [`friendsofphp/php-cs-fixer`](http://github.com/FriendsOfPHP/PHP-CS-Fixer).

## Installation

Run

```sh
$ composer require --dev localheinz/php-cs-fixer-config
```

## Usage

### Configuration

Pick one of the rule sets:

* `Localheinz\PhpCsFixer\RuleSet\Php56`
* `Localheinz\PhpCsFixer\RuleSet\Php70`
* `Localheinz\PhpCsFixer\RuleSet\Php71`

Create a configuration file `.php_cs` in the root of your project:

```php
<?php

use Localheinz\PhpCsFixer\Config;

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php56());

$config->getFinder()->in(__DIR__);

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;
```

:bulb: Optionally specify a header:

```php
<?php

use Localheinz\PhpCsFixer\Config;

$header = <<<EOF
Copyright (c) 2017 Andreas Möller

For the full copyright and license information, please view
the LICENSE file that was distributed with this source code.

@link https://github.com/localheinz/php-cs-fixer-config
EOF;

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php56($header));

$config->getFinder()->in(__DIR__);

$cacheDir = \getenv('TRAVIS') ? \getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;
```

This will enable and configure the [`HeaderCommentFixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.1.1/src/Fixer/Comment/HeaderCommentFixer.php), so that
file headers will be added to PHP files, for example:

```php
<?php

/**
 * Copyright (c) 2017 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/php-cs-fixer-config
 */
```

### Git

Add `.php_cs.cache` (this is the cache file created by `php-cs-fixer`) to `.gitignore`:

```
vendor/
.php_cs.cache
```

### Travis

Update your `.travis.yml` to cache the directory containing the `php_cs.cache` file:

```yml
cache:
  directories:
    - $HOME/.php-cs-fixer
```

Then run `php-cs-fixer` in the `script` section:

```yml
script:
  - vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --diff --dry-run
```

If you only want to run `php-cs-fixer` on one PHP version, update your build matrix and use a condition:

```yml
matrix:
  include:
    - php: 5.6
      env: WITH_CS=true
    - php: 5.6
      env: WITH_COVERAGE=true

script:
  - if [[ "$WITH_CS" == "true" ]]; then vendor/bin/php-cs-fixer fix --config=.php_cs --diff --dry-run --verbose; fi
```

### Makefile

Create a `Makefile` with a `cs` target:

```Makefile
.PHONY: composer cs

composer:
	composer validate
	composer install

cs: composer
	vendor/bin/php-cs-fixer fix --config=.php_cs --diff --verbose
```

## Fixing issues

Run

```
$ make cs
```

## Contributing

Please have a look at [CONTRIBUTING.md](.github/CONTRIBUTING.md).

## License

This package is licensed using the MIT License.
