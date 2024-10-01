# Set

The Set object holds only unique values of any type.

## Standard built-in objects

- [`Set() constructor`](#new-set)
- [`Set::add()`](#setadd)
- [`Set::clear()`](#setclear)
- [`Set::delete()`](#setdelete)
- [`Set::difference()`](#setdifference)
- [`Set::entries()`](#setentries)
- [`Set::forEach()`](#setforeach)
- [`Set::has()`](#sethas)
- [`Set::intersection()`](#setintersection)
- [`Set::isSubsetOf()`](#setissubsetof)
- [`Set::isSupersetOf()`](#setissupersetof)
- [`Set::keys()`](#setkeys)
- [`Set::union()`](#setunion)
- [`Set::values()`](#setvalues)
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

### Set::difference()

The `difference()` method returns a new Set containing elements in this Set but not in the given Set.

```php
$odds = new Set([1, 3, 5, 7, 9]);
$squares = new Set([1, 4, 9]);

$set->difference($squares);
// Set[3, 5, 7]
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

### Set::forEach()

The `forEach()` method executes a provided function once per each element of the Set.

```php
$set = new Set([3, 0]);

$set->forEach(function (int $value1, int $value2, Set $set) {
    // ...
});
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

### Set::intersection()

The `intersection()` method returns a new set containing only those elements that exist in both sets.

```php
$odds = new Set([1, 3, 5, 7, 9]);
$squares = new Set([1, 4, 9]);

$set->union($squares);
// Set[1, 9]
```

### Set::isSubsetOf()

The `isSubsetOf()` method checks if all elements of a Set are in a given Set.

```php
$fours = new Set([4, 8, 12, 16]);
$evens = new Set([2, 4, 6, 8, 10, 12, 14, 16, 18]);

$fours->isSubsetOf($evens);
// true
```

### Set::isSupersetOf()

The `isSupersetOf()` method checks if all elements of the given Set are in the Set.

```php
$evens = new Set([2, 4, 6, 8, 10, 12, 14, 16, 18]);
$fours = new Set([4, 8, 12, 16]);

$evens->isSupersetOf($fours);
// true
```

### Set::keys()

The `keys()` method is exactly equivalent to the [values()](#setvalues) method.

```php
$set = new Set(['foo' => 'bar']);

$iterator = $set->keys();
// [object SetIterator]

$iterator->current();
// 'foo'
```

### Set::union()

The `union()` method returns a new Set containing elements from both Sets.

```php
$odds = new Set([1, 3, 5, 7, 9]);
$squares = new Set([1, 4, 9]);

$set->union($squares);
// Set[1, 3, 5, 7, 9, 4]
```

### Set::values()

The `values()` method returns a new `SetIterator` instance that contain the values of each element of the Set.

```php
$set = new Set(['foo', 'bar']);

$iterator = $set->values();
// [object SetIterator]

$iterator->current();
// 'foo'

$iterator->next();
// 'bar'
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
