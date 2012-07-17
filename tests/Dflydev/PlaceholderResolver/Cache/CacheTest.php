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

class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGet()
    {
        $object = new CacheTestToSTring;

        $cache = new Cache;
        $cache->set(1, "one as integer");
        $cache->set("2", "two as string '2'");
        $cache->set("three", "three as string");
        $cache->set($object, "object");

        $this->assertEquals("one as integer", $cache->get(1));
        $this->assertEquals("two as string '2'", $cache->get('2'));
        $this->assertEquals("three as string", $cache->get('three'));
        $this->assertEquals("object", $cache->get($object));

        $this->assertNull($cache->get(11));
        $this->assertNull($cache->get('12'));
        $this->assertNull($cache->get('thirteen'));
    }

    public function testExists()
    {
        $object = new CacheTestToSTring;

        $cache = new Cache;

        $this->assertFalse($cache->exists(1));
        $this->assertFalse($cache->exists("2"));
        $this->assertFalse($cache->exists("three"));
        $this->assertFalse($cache->exists($object));
    }

    public function testExistsArray()
    {
        $array = array();

        $cache = new Cache;

        $this->setExpectedException('RuntimeException');

        $cache->exists($array);
    }

    public function testGetArray()
    {
        $array = array();

        $cache = new Cache;

        $this->setExpectedException('RuntimeException');

        $cache->get($array);
    }

    public function testSetArray()
    {
        $array = array();

        $cache = new Cache;

        $this->setExpectedException('RuntimeException');

        $cache->set($array, 'broken');
    }

    public function testExistsNoToString()
    {
        $object = new CacheTestNoToSTring;

        $cache = new Cache;

        $this->setExpectedException('PHPUnit_Framework_Error');

        $cache->exists($object);
    }

    public function testGetNoToString()
    {
        $object = new CacheTestNoToSTring;

        $cache = new Cache;

        $this->setExpectedException('PHPUnit_Framework_Error');

        $cache->get($object);
    }

    public function testSetNoToString()
    {
        $object = new CacheTestNoToSTring;

        $cache = new Cache;

        $this->setExpectedException('PHPUnit_Framework_Error');

        $cache->set($object, 'broken');
    }
}

class CacheTestNoToSTring
{
}

class CacheTestToSTring
{
    public function __toString()
    {
        return 'any string';
    }
}
