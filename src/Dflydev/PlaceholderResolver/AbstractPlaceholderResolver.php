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

use Dflydev\PlaceholderResolver\Cache\Cache;
use Dflydev\PlaceholderResolver\Cache\CacheInterface;

abstract class AbstractPlaceholderResolver implements PlaceholderResolverInterface
{
    private $cache;
    protected $maxReplacementDepth = 10;

    /**
     * Set maximum depth for recursive replacement
     *
     * @param int $maxReplacementDepth
     *
     * @return PlaceholderResolver
     */
    public function setMaxReplacementDepth($maxReplacementDepth)
    {
        $this->maxReplacementDepth = $maxReplacementDepth;

        return $this;
    }

    /**
     * Get cache
     *
     * @return CacheInterface
     */
    public function getCache()
    {
        if (null === $this->cache) {
            $this->cache = new Cache;
        }

        return $this->cache;
    }

    /**
     * Set cache
     *
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
}
