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

class RegexPlaceholderResolverCallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testCallback()
    {
        $dataSource = $this->getMock('Dflydev\PlaceholderResolver\DataSource\DataSourceInterface');
        $dataSource
            ->expects($this->any())
            ->method('exists')
            ->will($this->returnValueMap(array(
                array('foo', false, true),
                array('bar', false, true),
                array('baz', false, true),
                array('bat', false, false),
                array('foo', true, true),
                array('bar', true, false),
            )))
        ;
        $dataSource
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap(array(
                array('foo', false, 'FOO'),
                array('bar', false, 'BAR'),
                array('baz', false, 'BAZ'),
                array('foo', true, 'SYSTEM FOO'),
            )))
        ;

        $placeholderResolverCallback = new RegexPlaceholderResolverCallback($dataSource);

        define('TEST_CONSTANT_RESOLVE', 'abc123');

        $this->assertEquals('FOO', $placeholderResolverCallback->callback(array('${foo}', 'foo')));
        $this->assertEquals('BAR', $placeholderResolverCallback->callback(array('${bar}', 'bar')));
        $this->assertEquals('BAZ', $placeholderResolverCallback->callback(array('${baz}', 'baz')));
        $this->assertEquals('${bat}', $placeholderResolverCallback->callback(array('${bat}', 'bat')));
        $this->assertEquals('SYSTEM FOO', $placeholderResolverCallback->callback(array('${SYSTEM:foo}', 'SYSTEM:foo')));
        $this->assertEquals('${SYSTEM:bar}', $placeholderResolverCallback->callback(array('${SYSTEM:bar}', 'SYSTEM:bar')));
        $this->assertEquals('SYSTEM FOO', $placeholderResolverCallback->callback(array('${SERVER:foo}', 'SERVER:foo')));
        $this->assertEquals('${SERVER:bar}', $placeholderResolverCallback->callback(array('${SERVER:bar}', 'SERVER:bar')));
        $this->assertEquals('abc123', $placeholderResolverCallback->callback(array('${CONSTANT:TEST_CONSTANT_RESOLVE}', 'CONSTANT:TEST_CONSTANT_RESOLVE')));
        $this->assertEquals('${CONSTANT:MISSING_TEST_CONSTANT_RESOLVE}', $placeholderResolverCallback->callback(array('${CONSTANT:MISSING_TEST_CONSTANT_RESOLVE}', 'CONSTANT:MISSING_TEST_CONSTANT_RESOLVE')));
    }
}
