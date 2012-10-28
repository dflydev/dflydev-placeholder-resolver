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

/**
 * Array Data Source
 *
 * Simple array based implementation of the Data Source Interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayDataSource implements DataSourceInterface
{
    /**
     * @var array
     */
    protected $array;

    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array = array())
    {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key, $system = false)
    {
        if ($system) {
            return false;
        }

        return isset($this->array[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $system = false)
    {
        if ($system) {
            return null;
        }

        return isset($this->array[$key]) ? $this->array[$key] : null;
    }
}
