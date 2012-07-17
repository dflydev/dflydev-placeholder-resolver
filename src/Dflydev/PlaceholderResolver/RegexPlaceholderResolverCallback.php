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

class RegexPlaceholderResolverCallback
{
    /**
     * @var DataSourceInterface
     */
    private $dataSource;

    /**
     * Constructor
     *
     * @param DataSourceInterface $dataSource
     */
    public function __construct(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Callback for preg_replace_callback() generally called in PlaceholderResolver
     *
     * The expected input will be array($fullMatch, $potentialKey) and the
     * expected output will be either a value from the data source, a special
     * value from SERVER or CONSTANT, or the contents of $fullMatch (the key
     * itself with its wrapped prefix and suffix).
     *
     * @param array $matches
     *
     * @return string|null
     */
    public function callback($matches)
    {
        list ($fullMatch, $potentialKey) = $matches;
        if (preg_match('/^(SYSTEM|SERVER|CONSTANT):(\w+)$/', $potentialKey, $specialMatches)) {
            list ($dummy, $which, $specialKey) = $specialMatches;
            switch ($which) {
                case 'SERVER':
                case 'SYSTEM':
                    if ($this->dataSource->exists($specialKey, true)) {
                        return $this->dataSource->get($specialKey, true);
                    }
                    break;
                case 'CONSTANT':
                    if (defined($specialKey)) {
                        return constant($specialKey);
                    }
                    break;
            }
        }

        if ($this->dataSource->exists($potentialKey)) {
            return $this->dataSource->get($potentialKey);
        }

        return $fullMatch;
    }
}
