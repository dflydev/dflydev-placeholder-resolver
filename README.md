Placeholder Resolver
====================

Provides a mechanism to resolve placeholders from an arbitrary data
source.

Placeholder Resolver is intended to be used at a relatively low level.
For example, a configuration library could use Placeholder Resolver
behind the scenes.

Requirements
------------

 * PHP 5.3+


Usage
-----

    use Dflydev\PlaceholderResolver\PlaceholderResolver;
    
    // YourDataSource implements Dflydev\PlaceholderResolver\DataSourceInterface
    $dataSource = new YourDataSource;

    // Create the placeholder resolver
    $placeholderResolver = new PlaceholderResolver($dataSource);

    // Start resolving placeholders
    $value = $placeholderResolver->resolvePlaceholder('${foo}');

The `PlaceholderResolver` constructor accepts two additional arguments,
a placeholder prefix and a placeholder suffix. The default placeholder
prefix is `${` and the default placeholder suffix is `}`.

To handle placeholders that look like `<foo.bar>` instead of `${foo.bar}`,
one would instantiate the class like this:

    $placeholderResolver = new PlaceholderResolver($dataSource, '<', '>');

Placeholders can recursively resolve placeholders. For example, given a
data source with the following:

    array(
        'foo' => 'FOO',
        'bar' => 'BAR',
        'FOO.BAR' => 'BAZ!',
    );

The placeholder `${${foo}.${bar}}` would internally be resolved to
`${FOO.BAR}` before being further resolved to `BAZ!`.


License
-------

This library is licensed under the New BSD License - see the LICENSE file
for details.


Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.


Not Invented Here
-----------------

Much of the ideas behind this library came from Spring's Property
Placeholder Configurer implementation.