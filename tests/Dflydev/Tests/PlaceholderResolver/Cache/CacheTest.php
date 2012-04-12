<?php

/*
 * This file is a part of dflydev/placeholder-resolver.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\PlaceholderResolver\Cache;

use Dflydev\PlaceholderResolver\Cache\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGet()
    {
        $array = array();
        $object = new CacheTestToSTring;

        $cache = new Cache;
        $cache->set(1, "one as integer");
        $cache->set("2", "two as string '2'");
        $cache->set("three", "three as string");
        $cache->set($array, "array");
        $cache->set($object, "object");

        $this->assertEquals("one as integer", $cache->get(1));
        $this->assertEquals("two as string '2'", $cache->get('2'));
        $this->assertEquals("three as string", $cache->get('three'));
        $this->assertEquals("array", $cache->get($array));
        $this->assertEquals("object", $cache->get($object));

        $this->assertNull($cache->get(11));
        $this->assertNull($cache->get('12'));
        $this->assertNull($cache->get('thirteen'));
    }

    public function testExists()
    {
        $array = array();
        $object = new CacheTestToSTring;

        $cache = new Cache;

        $this->assertFalse($cache->exists(1));
        $this->assertFalse($cache->exists("2"));
        $this->assertFalse($cache->exists("three"));
        $this->assertFalse($cache->exists($array));
        $this->assertFalse($cache->exists($object));
    }
}

class CacheTestToSTring
{
    public function __toString()
    {
        return 'any string';
    }
}