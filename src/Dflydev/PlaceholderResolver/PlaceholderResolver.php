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

class PlaceholderResolver implements PlaceholderResolverInterface
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
     * Cache of resolved placeholders
     */
    private $resolved = array();

    /**
     * Constructor
     * 
     * @param DataSourceInterface $dataSource
     * @param string|null $placeholderPrefix
     * @param string|null $placeholderSuffix
     */
    public function __construct(DataSourceInterface $dataSource, $placeholderPrefix = '${', $placeholderSuffix = '}')
    {
        $this->placeholderResolverCallback = new PlaceholderResolverCallback($dataSource);
        $placeholderPrefix = preg_quote($placeholderPrefix);
        $placeholderSuffix = preg_quote($placeholderSuffix);
        $this->pattern = "/{$placeholderPrefix}([a-zA-Z0-9\.\(\)_\:]+?){$placeholderSuffix}/";
    }

    /**
     * {@inheritdoc}
     */
    public function resolvePlaceholder($placeholder)
    {
        if (array_key_exists($placeholder, $this->resolved)) {
            print " [returning previously resolved value for $placeholder as ".$this->resolved[$placeholder]. "]\n";
            return $this->resolved[$placeholder];
        }

        $value = $placeholder;
        $counter = 0;

        while ($counter++ < 10) {
            $newValue = preg_replace_callback(
                $this->pattern,
                array($this->placeholderResolverCallback, 'callback'),
                $value
            );
            if ($newValue === $value) { break; }
            $value = $newValue;
        }

        return $this->resolved[$placeholder] = $value;;
    }
}