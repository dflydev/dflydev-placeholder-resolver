<?php

/*
 * This file is a part of dflydev/placeholder-resolver.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\PlaceholderResolver;

use Dflydev\PlaceholderResolver\DataSource\DataSourceInterface;

class RegexPlaceholderResolver extends AbstractPlaceholderResolver
{
    /**
     * @var PlaceholderResolverCallback
     */
    private $placeholderResolverCallback;

    /**
     * @var string
     */
    private $pattern;

    /**
     * Constructor
     *
     * @param DataSourceInterface $dataSource
     * @param string|null         $placeholderPrefix
     * @param string|null         $placeholderSuffix
     */
    public function __construct(DataSourceInterface $dataSource, $placeholderPrefix = '${', $placeholderSuffix = '}')
    {
        $this->placeholderResolverCallback = new RegexPlaceholderResolverCallback($dataSource);
        $placeholderPrefix = preg_quote($placeholderPrefix);
        $placeholderSuffix = preg_quote($placeholderSuffix);
        $this->pattern = "/{$placeholderPrefix}([a-zA-Z0-9\.\(\)_\:]+?){$placeholderSuffix}/";
    }

    /**
     * {@inheritdoc}
     */
    public function resolvePlaceholder($placeholder)
    {
        if (!is_string($placeholder)) {
            return $placeholder;
        }

        if ($this->getCache()->exists($placeholder)) {
            return $this->getCache()->get($placeholder);
        }

        $value = $placeholder;
        $counter = 0;

        while ($counter++ < $this->maxReplacementDepth) {
            $newValue = preg_replace_callback(
                $this->pattern,
                array($this->placeholderResolverCallback, 'callback'),
                (string)$value
            );
            if ($newValue === $value) { break; }
            $value = $newValue;
        }

        $this->getCache()->set($placeholder, $value);

        return $value;
    }
}
