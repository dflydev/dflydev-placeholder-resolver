<?php

/*
 * This file is a part of dflydev/placeholder-resolver.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\PlaceholderResolver\Cache;

class Cache implements CacheInterface
{
    private $cache = array();

    /**
     * {@inheritdoc}
     */
    public function exists($placeholder)
    {
        if (is_array($placeholder)) {
            throw new \RuntimeException('Placeholder is an array');
        }

        return array_key_exists((string) $placeholder, $this->cache);
    }

    /**
     * {@inheritdoc}
     */
    public function get($placeholder)
    {
        if (is_array($placeholder)) {
            throw new \RuntimeException('Placeholder is an array');
        }

        return array_key_exists((string) $placeholder, $this->cache)
            ? $this->cache[(string) $placeholder]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($placeholder, $value = null)
    {
        if (is_array($placeholder)) {
            throw new \RuntimeException('Placeholder is an array');
        }
        $this->cache[(string) $placeholder] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->cache = array();
    }
}
