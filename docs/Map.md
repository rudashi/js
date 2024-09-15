# Map

The Map object holds key-value pairs and remembers the original insertion order of the keys. Any value (both objects and
primitive values) may be used as either a key or a value.

## Standard built-in objects

- [`Map() constructor`](#new-map)
- [`Map::clear()`](#mapclear)
- [`Map::delete()`](#mapdelete)
- [`Map::get()`](#mapget)
- [`Map::has()`](#maphas)
- [`Map::keys()`](#mapkeys)
- [`Map::set()`](#mapset)
- [`Map::size`](#mapsize)

## Constructor

### new Map()

Creates a new Map object.

```php
// array
$myMap = new Map(['foo', 'bar']);

// null
$myMap = new Map(null);

// object
$myMap = new Map(new \stdClass());

// string
$myMap = new Map('one');
```

## Static methods

## Methods

### Map::clear()

The `clear()` method removes all elements from map.

```php
$myMap = new Map(['foo' => 'bar']);

$myMap->size;
// 1

$myMap->clear();

$myMap->size;
// 0
```

### Map::delete()

The `delete()` method removes a specified element from map.

```php
$myMap = new Map(['foo' => 'bar']);

$myMap->delete('foo');
// true

$myMap->delete(1);
// false
```

### Map::get()

The `get()` method returns a specified element from map.

```php
$myMap = new Map([1, 'foo' => 'bar', 3]);

$myMap->get('foo');
// 'bar'

$myMap->get(1);
// 3

$myMap->get(2);
// null
```

### Map::has()

The `has()` method returns `TRUE` when element with the specified key exists in the Map or `FALSE` if it does not exist.

```php
$myMap = new Map(['foo' => 'bar']);

$myMap->has('foo');
// true

$myMap->has('baz');
// false
```

### Map::keys()

The `keys()` method returns a new `MapIterator` instance that contain the keys of each element of the Map.

```php
$myMap = new Map(['foo' => 'bar']);

$iterator = $myMap->keys();
// [object MapIterator]

$iterator->current();
// 'foo'
```

### Map::set()

The `set()` method adds or updates an element in map with a specified key and a value.

```php
$myMap = new Map();

$myMap->set('foo', 'bar');
// ['foo' => 'bar']

$myMap->set(1, 'baz');
// ['foo' => 'bar', 1 => 'baz']

$myMap->set(null, 'foobar');
// ['foo' => 'bar', 1 => 'baz', 2 => 'foobar']

$myMap->set('foo', 'baz');
// ['foo' => 'baz', 1 => 'baz', 2 => 'foobar']

$myMap->set(null, 'first')->set(null, 'second');
// ['foo' => 'baz', 1 => 'baz', 2 => 'foobar', 3 => 'first', 4 => 'second']
```

## Properties

### Map::size

The `size` property returns numbers of elements from map.

```php
$myMap = new Map(['foo' => 'bar']);

$myMap->size;
// 1

$myMap->delete('foo');
$myMap->size;
// 0
```
