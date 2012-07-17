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

interface CacheInterface
{
    /**
     * Does specified placeholder exist?
     *
     * @param string $placeholder
     *
     * @return bool
     */
    public function exists($placeholder);

    /**
     * Get placeholder's value
     *
     * @param string $placeholder
     *
     * @return string|null
     */
    public function get($placeholder);

    /**
     * Set placeholder's value
     *
     * @param string      $placeholder
     * @param string|null $value
     *
     * @return string|null
     */
    public function set($placeholder, $value = null);

    /**
     * Flush cache
     */
    public function flush();
}
