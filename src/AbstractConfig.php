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

abstract class AbstractConfig extends Config
{
    /**
     * @param string $header
     *
     * @throws \InvalidArgumentException
     */
    final public function __construct($header = null)
    {
        $rules = $this->rules();

        if (null !== $header) {
            if (!\is_string($header)) {
                throw new \InvalidArgumentException(\sprintf(
                    'Header needs to be specified as null or a string. Got "%s" instead.',
                    \is_object($header) ? \get_class($header) : \gettype($header)
                ));
            }

            if ('' === \trim($header)) {
                throw new \InvalidArgumentException(\sprintf(
                    'If specified, header needs to be a non-blank string. Got "%s" instead.',
                    $header
                ));
            }

            $rules['header_comment'] = [
                'commentType' => 'PHPDoc',
                'header' => $header,
                'location' => 'after_declare_strict',
                'separate' => 'both',
            ];
        }

        parent::__construct($this->name());

        $this->setRiskyAllowed(true);
        $this->setRules($rules);
    }

    /**
     * @return string
     */
    abstract protected function name();

    /**
     * @return array
     */
    abstract protected function rules();
}
