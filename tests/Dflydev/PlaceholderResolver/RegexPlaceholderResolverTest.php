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

class PlaceholderResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testResolvePlaceholder()
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
                array('composite', false, true),
                array('FOO.BAR', false, true),
                array('FOO.BAR.BAZ', false, false),
            )))
        ;
        $dataSource
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap(array(
                array('foo', false, 'FOO'),
                array('bar', false, 'BAR'),
                array('baz', false, 'BAZ'),
                array('composite', false, '${foo}-${bar}'),
                array('FOO.BAR', false, 'Foo Dot Bar'),
            )))
        ;

        $placeholderResolver = new RegexPlaceholderResolver($dataSource);

        $this->assertEquals("FOO", $placeholderResolver->resolvePlaceholder('${foo}'));
        $this->assertEquals("BAR", $placeholderResolver->resolvePlaceholder('${bar}'));
        $this->assertEquals("BAZ", $placeholderResolver->resolvePlaceholder('${baz}'));
        $this->assertEquals("FOO-BAR", $placeholderResolver->resolvePlaceholder('${composite}'));
        $this->assertEquals("FOO-BAR-BAZ", $placeholderResolver->resolvePlaceholder('${composite}-${baz}'));
        $this->assertEquals("Foo Dot Bar", $placeholderResolver->resolvePlaceholder('${${foo}.${bar}}'));
        $this->assertEquals('${FOO.BAR.BAZ}', $placeholderResolver->resolvePlaceholder('${FOO.BAR.BAZ}'));
    }

    /**
     * @dataProvider resolvePlaceholderPrefixAndSuffixProvider
     */
    public function testResolvePlaceholderPrefixAndSuffix($prefix, $suffix)
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
                array('composite', false, true),
                array('FOO.BAR', false, true),
            )))
        ;
        $dataSource
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap(array(
                array('foo', false, 'FOO'),
                array('bar', false, 'BAR'),
                array('baz', false, 'BAZ'),
                array('composite', false, $prefix.'foo'.$suffix.'-'.$prefix.'bar'.$suffix),
                array('FOO.BAR', false, 'Foo Dot Bar'),
            )))
        ;

        $placeholderResolver = new RegexPlaceholderResolver($dataSource, $prefix, $suffix);
        $this->assertEquals("FOO", $placeholderResolver->resolvePlaceholder($prefix.'foo'.$suffix));
        $this->assertEquals($prefix.'bat'.$suffix, $placeholderResolver->resolvePlaceholder($prefix.'bat'.$suffix));
        $this->assertEquals("FOO-BAR", $placeholderResolver->resolvePlaceholder($prefix.'composite'.$suffix));
        $this->assertEquals("FOO-BAR-BAZ", $placeholderResolver->resolvePlaceholder($prefix.'composite'.$suffix.'-'.$prefix.'baz'.$suffix));
        $this->assertEquals("Foo Dot Bar", $placeholderResolver->resolvePlaceholder($prefix.$prefix.'foo'.$suffix.'.'.$prefix.'bar'.$suffix.$suffix));
    }

    public function resolvePlaceholderPrefixAndSuffixProvider()
    {
        return array(
            array('%', '%'),
            array('<', '>'),
            array('(<)', '(>)'),
        );
    }

    public function testResolvePlaceholderReturnType()
    {
        $dataSource = $this->getMock('Dflydev\PlaceholderResolver\DataSource\DataSourceInterface');
        $dataSource
            ->expects($this->any())
            ->method('exists')
            ->will($this->returnValueMap(array(
                array('true', false, true),
                array('int', false, true),
                array('composite', false, true),
            )))
        ;
        $dataSource
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap(array(
                array('true', false, true),
                array('int', false, 2015),
                array('composite', false, '${int}'),
            )))
        ;

        $placeholderResolver = new RegexPlaceholderResolver($dataSource);

        $this->assertSame(true, $placeholderResolver->resolvePlaceholder(true));
        $this->assertSame(false, $placeholderResolver->resolvePlaceholder(false));
        $this->assertSame(2015, $placeholderResolver->resolvePlaceholder(2015));
        $this->assertSame(2015.0914, $placeholderResolver->resolvePlaceholder(2015.0914));
        $this->assertSame('2015', $placeholderResolver->resolvePlaceholder('2015'));
        $this->assertSame('2015', $placeholderResolver->resolvePlaceholder('${int}'));
        $this->assertSame('1', $placeholderResolver->resolvePlaceholder('${true}'));
        $this->assertSame('2015', $placeholderResolver->resolvePlaceholder('${composite}'));
    }
}
