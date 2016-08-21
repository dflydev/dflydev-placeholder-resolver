# Placeholder Resolver

Given a data source representing key => value pairs, resolve placeholders
like `${foo.bar}` to the value associated with the `foo.bar` key in
the data source.

Placeholder Resolver is intended to be used at a relatively low level.
For example, a configuration library could use Placeholder Resolver
behind the scenes to allow for configuration values to reference
other configuration values.

## Example

```yml
conn.driver: mysql
conn.db_name: example
conn.hostname: 127.0.0.1
conn.username: root
conn.password: pa$$word
```

Given the appropriate `DataSourceInterface` implementation to provide
the above data as a set of key => value pairs, the Placeholder Resolver
would resolve the value of `$dsnPattern` to `mysql:dbname=example;host=127.0.0.1`.

```php
$dsnPattern = '${conn.driver}:dbname=${conn.db_name};host=${conn.hostname}';
$dsn = $placeholderResolver->resolveValue($dsnPattern);
// mysql:dbname=example;host=127.0.0.1
```

## Requirements

 * PHP 5.3+

## Usage

```php
use Dflydev\PlaceholderResolver\RegexPlaceholderResolver;

// YourDataSource implements Dflydev\PlaceholderResolver\DataSource\DataSourceInterface
$dataSource = new YourDataSource;

// Create the placeholder resolver
$placeholderResolver = new RegexPlaceholderResolver($dataSource);

// Start resolving placeholders
$value = $placeholderResolver->resolvePlaceholder('${foo}');
```

The `RegexPlaceholderResolver` constructor accepts two additional arguments,
a placeholder prefix and a placeholder suffix. The default placeholder
prefix is `${` and the default placeholder suffix is `}`.

To handle placeholders that look like `<foo.bar>` instead of `${foo.bar}`,
one would instantiate the class like this:

```php
$placeholderResolver = new RegexPlaceholderResolver($dataSource, '<', '>');
```

Placeholders can recursively resolve placeholders. For example, given a
data source with the following:

```php
array(
    'foo' => 'FOO',
    'bar' => 'BAR',
    'FOO.BAR' => 'BAZ!',
);
```

The placeholder `${${foo}.${bar}}` would internally be resolved to
`${FOO.BAR}` before being further resolved to `BAZ!`.

Resolved placeholders are cached using the `CacheInterface`. The default
`Cache` implementation is used unless it is explicitly set on the
Placeholder Resolver.

```php
// YourCache implements Dflydev\PlaceholderResolver\Cache\CacheInterface
$cache = new YourCache;

$placeholderResolver->setCache($cache);
```

## License

This library is licensed under the New BSD License - see the LICENSE file
for details.

## Community

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.

## Not Invented Here

Much of the ideas behind this library came from Spring's Property
Placeholder Configurer implementation.
