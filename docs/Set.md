# Set

The Set object holds only unique values of any type.

## Standard built-in objects

- [`Set() constructor`](#new-set)
- [`Set::add()`](#setadd)
- [`Set::clear()`](#setclear)
- [`Set::delete()`](#setdelete)
- [`Set::entries()`](#setentries)
- [`Set::has()`](#sethas)
- [`Set::size`](#setsize)

## Constructor

### new Set()

Creates a new Set object.

```php
$set = new Set(['foo', 'bar', 'foo']);
// ['foo', 'bar']
```

## Static methods

## Methods

### Set::add()

The `add()` method adds a new element in to Set.

```php
$set = new Set();

$set->add(40);
// [40]

$set->add('first')->add('second');
// [40, 'first', 'second']
```

Values are always unique.

```php
$set = new Set();

$set->add(40);
// [40]

$set->add('first')->add('second');
// [40, 'first', 'second']

$set->add(40)->add('second');
// [40, 'first', 'second']
```

### Set::clear()

The `clear()` method removes all elements from the Set.

```php
$set = new Set(['foo', 'bar']);

$set->size;
// 2

$set->clear();

$set->size;
// 0
```

### Set::delete()

The `delete()` method removes a specified value from the Set.

```php
$set = new Set(['foo', 'bar']);

$set->delete('foo');
// true

$set->delete(1);
// false
```

### Set::entries()

The `entries()` method returns a new `SetIterator` instance that contain pair array `[value, value]` of each element of the Set.

```php
$set = new Set(['foo', 'bar']);

$iterator = $set->entries();
// [object SetIterator]

$iterator->current();
// ['foo', ''foo']
```

### Set::has()

The `has()` method returns `TRUE` when element with the specified value exists in the `Set` or `FALSE` if it does not exist.

```php
$set = new Set([1, 2, 3, 4, 5]);

$set->has(1);
// true

$set->has(6);
// false
```

## Properties

### Set::size

The `size` property returns number of elements from the Set.

```php
$set = new Set(['foo', 'bar']);

$set->size;
// 2

$set->delete('foo');
$set->size;
// 1
```
