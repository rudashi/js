# Set

The Set object holds only unique values of any type.

## Standard built-in objects

- [`Set() constructor`](#new-set)
- [`Set::add()`](#setadd)
- [`Set::has()`](#sethas)

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
