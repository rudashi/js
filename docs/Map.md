# Map

The Map object holds key-value pairs and remembers the original insertion order of the keys. Any value (both objects and
primitive values) may be used as either a key or a value.

## Standard built-in objects

- [`Map() constructor`](#new-map)

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