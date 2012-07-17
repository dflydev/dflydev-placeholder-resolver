<?php

/*
 * This file is a part of dflydev/placeholder-resolver.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\PlaceholderResolver\DataSource;

interface DataSourceInterface
{
    /**
     * Does specified key exist?
     *
     * If $system is true, check system data. Otherwise,
     * use application data. (think system == $_SERVER)
     *
     * @param string    $key
     * @param bool|null $system
     *
     * @return bool
     */
    public function exists($key, $system = false);

    /**
     * Get key's value
     *
     * If $system is true, check system data. Otherwise,
     * use application data. (think system == $_SERVER)
     *
     * @param string    $key
     * @param bool|null $system
     *
     * @return string|null
     */
    public function get($key, $system = false);
}
