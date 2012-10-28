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
 * ArrayDataSource Test
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayDataSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic functionality
     */
    public function testBasic()
    {
        $dataSource = new ArrayDataSource(array(
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ));

        $this->assertTrue($dataSource->exists('a'));
        $this->assertTrue($dataSource->exists('b'));
        $this->assertTrue($dataSource->exists('c'));
        $this->assertFalse($dataSource->exists('d'));

        $this->assertFalse($dataSource->exists('a', true));
        $this->assertFalse($dataSource->exists('d', true));

        $this->assertEquals('A', $dataSource->get('a'));
        $this->assertEquals('B', $dataSource->get('b'));
        $this->assertEquals('C', $dataSource->get('c'));
        $this->assertNull($dataSource->get('d'));

        $this->assertNull($dataSource->get('a', true));
        $this->assertNull($dataSource->get('d', true));
    }
}
