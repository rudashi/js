<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use Rudashi\JavaScript\Set;
use Rudashi\JavaScript\SetIterator;
use stdClass;
use Tests\Fixtures\TraversableObject;

covers(Set::class);

describe('size property', function () {
    it('has fixed value on create', function () {
        $set = new Set(['foo']);

        expect($set->size)
            ->toBe(1);
    });

    it('increases when more elements', function () {
        $set = new Set([1, 'foo', 'bar', 3]);

        expect($set->size)
            ->toBe(4);

        $set->add('baz');

        expect($set->size)
            ->toBe(5);
    });

    it('does not change when add the same element', function () {
        $set = new Set([1, 'foo', 'bar', 3]);

        expect($set->size)
            ->toBe(4);

        $set->add('foo');

        expect($set->size)
            ->toBe(4);
    });

    it('decreases when remove elements', function () {
        $set = new Set([1, 'foo', 'bar', 3]);

        expect($set->size)
            ->toBe(4);

        $set->delete('foo');

        expect($set->size)
            ->toBe(3);
    });
});

describe('create', function () {
    test('Set', function () {
        $set = new Set();

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray([]);
    });

    test('Set from an array', function () {
        $array = [1, 2, 3, 4];
        $set = new Set($array);

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($array);
    });

    test('Set from a nested array', function () {
        $array = [[1, 'one'], [2, 'two']];
        $set = new Set($array);

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($array);
    });

    test('Set from an object', function () {
        $array = [new stdClass(), 0];
        $set = new Set($array);

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($array);
    });

    test('Set from a Traversable', function () {
        $array = [1, 0, 4];
        $set = new Set(new TraversableObject($array));

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($array);
    });

    test('SET with only unique values', function () {
        $set = new Set([1, 2, 2, 3, 4, 4]);

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray([1, 2, 3, 4]);
    });
});

describe('toArray', function () {
    $array = ['foo', 'bar'];
    $set = new Set($array);

    $result = $set->toArray();

    expect($result)
        ->toBeArray()
        ->toMatchArray($array);
});

describe('getArrayItems', function () {
    test('Traversable', function () {
        $items = [new stdClass(), new stdClass()];
        $set = callReflectMethod(new Set(), 'getArrayItems', new TraversableObject($items));

        expect($set)
            ->toBeArray()
            ->toMatchArray($items);
    });

    test('array', function () {
        $array = ['foo' => 'bar'];
        $set = callReflectMethod(new Set(), 'getArrayItems', $array);

        expect($set)
            ->toBeArray()
            ->toMatchArray($array);
    });

    test('object', function () {
        $object = [new stdClass()];
        $set = callReflectMethod(new Set(), 'getArrayItems', $object);

        expect($set)
            ->toBeArray()
            ->toMatchArray($object);
    });

    test('string', function () {
        $string = ['foo'];
        $set = callReflectMethod(new Set(), 'getArrayItems', $string);

        expect($set)
            ->toBeArray()
            ->toMatchArray($string);
    });

    test('null', function () {
        $null = [null];
        $set = callReflectMethod(new Set(), 'getArrayItems', $null);

        expect($set)
            ->toBeArray()
            ->toMatchArray($null);
    });
});

describe('unique', function () {
    test('integers', function () {
        $result = callReflectMethod(new Set(), 'unique', [1, 2, 3, 2, 4, 5, 1]);

        expect($result)
            ->toBeArray()
            ->toMatchArray([1, 2, 3, 4, 5]);
    });

    test('different types', function () {
        $array = [1, '1', 0, '0'];
        $result = callReflectMethod(new Set(), 'unique', $array);

        expect($result)
            ->toBeArray()
            ->toMatchArray($array);
    });

    test('object', function () {
        $object = [(object) ['foo' => 'bar'], (object) ['foo' => 'bar']];
        $result = callReflectMethod(new Set(), 'unique', $object);

        expect($result)
            ->toBeArray()
            ->toMatchArray($object);
    });

    test('string', function () {
        $result = callReflectMethod(new Set(), 'unique', ['foo', 'bar', 'bar', 'foo']);

        expect($result)
            ->toBeArray()
            ->toMatchArray(['foo', 'bar']);
    });

    test('mixed', function () {
        $result = callReflectMethod(new Set(), 'unique', [1, 'foo', 1, null, 'foo']);

        expect($result)
            ->toBeArray()
            ->toMatchArray([1, 'foo', null]);
    });
});

describe('add', function () {
    test('adds entry', function () {
        $set = new Set();

        $set->add(40);

        expect($set)
            ->toMatchArray([40]);
    });

    test('is chainable', function () {
        $set = new Set();

        $set->add(40)->add('some text');

        expect($set)
            ->toMatchArray([40, 'some text']);
    });

    test('skip duplicate value', function () {
        $set = new Set();

        $set->add(40)->add(40);

        expect($set)
            ->toMatchArray([40]);
    });
});

describe('clear', function () {
    test('removes all elements', function () {
        $set = new Set([1, ['foo' => 'bar'], 3]);

        $set->clear();

        expect($set->size)
            ->tobe(0);
    });

    test('returns void', function () {
        $reflection = reflectMethod(Set::class, 'clear');

        expect($reflection->getReturnType())
            ->getName()->toBe('void');
    });
});

describe('delete', function () {
    test('returns true on success', function () {
        $set = new Set([1, 'foo', 3]);

        expect($set->delete('foo'))
            ->toBeTrue();
    });

    test('returns false on failure', function () {
        $set = new Set([1, 'foo', 3]);

        expect($set->delete('bar'))
            ->toBeFalse();
    });
});

describe('entries', function () {
    it('returns new SetIterator', function () {
        $set = new Set(['foo', 'bar']);

        $newSet = $set->entries();

        expect($newSet)
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe(['foo', 'foo'])
            ->next()?->toBe(['bar', 'bar']);
    });

    it('returns Set elements', function () {
        $set = new Set(['foo', 'bar', 'baz', '2', 'boo']);

        $newSet = $set->entries();

        expect($newSet)
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe(['foo', 'foo'])
            ->next()?->toBe(['bar', 'bar'])
            ->next()?->toBe(['baz', 'baz']);
    });

    it('returns null when no more value is present', function () {
        $set = new Set(['foo']);

        $newSet = $set->entries();

        expect($newSet)
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe(['foo', 'foo'])
            ->next()?->toBeNull();
    });
});

describe('forEach', function () {
    test('iterate on every element', function () {
        $result = [];

        (new Set([2, 5, 9]))->forEach(function ($value1, $value2) use (&$result) {
            $result[$value1] = $value2 * 2;
        });

        expect($result)
            ->toBeArray()
            ->toMatchArray([2 => 4, 5 => 10, 9 => 18]);
    });

    test('not change original Set', function () {
        $result = [];

        $set = new Set([2, 5, 9]);
        $set->forEach(function ($value1, $value2) use (&$result) {
            $result[$value1] = $value2 * 2;
        });

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray([2, 5, 9]);
    });

    test('has access to Set inside loop', function () {
        $result = [];

        $set = new Set([2, 5, 9]);
        $set->forEach(function ($value1, $value2, $Set) use (&$result) {
            $result[] = $Set;
        });

        expect($result)
            ->toBeArray()
            ->each->toBeInstanceOf(Set::class);
    });

    test('can use arrow function', function () {
        $set = new Set();

        (new Set([2, 5, 9]))->forEach(fn ($value, $key) => $set->add($value * 2));

        expect($set)
            ->toBeInstanceOf(Set::class)
            ->toMatchArray([4, 10, 18]);
    });
});

describe('has', function () {
    it('returns true when value exists', function (mixed $key) {
        $set = new Set([1, 'foo' => 'bar', 3]);

        expect($set->has($key))
            ->toBeTrue();
    })->with([1, 3, 'bar']);

    it('returns false on non exists', function (mixed $key) {
        $set = new Set([1, 'foo' => 'bar', 3]);

        expect($set->has($key))
            ->toBeFalse();
    })->with([0, 'foo', '1', 2, null]);
});

describe('keys', function () {
    it('returns new SetIterator', function () {
        $set = new Set(['foo', 'bar']);

        expect($set->keys())
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe('foo')
            ->next()?->toBe('bar');
    });

    test('keys are equivalent to values()', function () {
        $set = new Set(['foo' => 'bar']);

        expect($set->keys())
            ->toBeInstanceOf(SetIterator::class)
            ->toArray()->toBe($set->values()->toArray());
    });
});

describe('values', function () {
    it('returns new SetIterator', function () {
        $set = new Set(['foo', 'bar']);

        $newMap = $set->values();

        expect($newMap)
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe('foo')
            ->next()?->toBe('bar');
    });

    it('returns values', function () {
        $set = new Set(['foo' => 'bar', 'baz' => 'boo']);

        $newMap = $set->values();

        expect($newMap)
            ->toBeInstanceOf(SetIterator::class)
            ->current()?->toBe('bar')
            ->next()?->toBe('boo');
    });

    test('is equivalent to keys() method', function () {
        $set = new Set(['foo', 'bar']);

        expect($set->values())
            ->toBeInstanceOf(SetIterator::class)
            ->toArray()->toBe($set->keys()->toArray());
    });
});

describe('operations method', function () {
    test('difference', function (array $a, array $b, array $expected) {
        $set_a = new Set($a);
        $set_b = new Set($b);

        expect($set_a->difference($set_b))
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($expected);
    })->with([
        'default' => [[1, 3, 5, 7, 9], [1, 4, 9], [3, 5, 7]],
        'empty' => [[1, 2, 3, 4], [2, 4, 3, 2], []],
        '`a` minus `b`' => [[1, 2, 3, 4], [5, 4, 3, 2], [1]],
        '`b` minus `a`' => [[5, 4, 3, 2], [1, 2, 3, 4], [5]],
    ]);

    test('intersection', function (array $a, array $b, array $expected) {
        $set_a = new Set($a);
        $set_b = new Set($b);

        expect($set_a->intersection($set_b))
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($expected);
    })->with([
        'default' => [[1, 3, 5, 7, 9], [1, 4, 9], [1, 9]],
        '`a` | `b`' => [[1, 2, 3, 4], [5, 4, 3, 2], [2, 3, 4]],
        '`b` | `a`' => [[5, 4, 3, 2], [1, 2, 3, 4], [4, 3, 2]],
    ]);

    test('union', function (array $a, array $b, array $expected) {
        $set_a = new Set($a);
        $set_b = new Set($b);

        expect($set_a->union($set_b))
            ->toBeInstanceOf(Set::class)
            ->toMatchArray($expected);
    })->with([
        'default' => [[1, 3, 5, 7, 9], [1, 4, 9], [1, 3, 5, 7, 9, 4]],
        '`a` plus `b`' => [[1, 2, 3, 4], [5, 4, 3, 2], [1, 2, 3, 4, 5]],
        '`b` plus `a`' => [[5, 4, 3, 2], [1, 2, 3, 4], [5, 4, 3, 2, 1]],
    ]);
});

describe('subset and superset', function () {
    it('subset', function (array $a, array $b, bool $expected) {
        $set_a = new Set($a);
        $set_b = new Set($b);

        expect($set_a->isSubsetOf($set_b))
            ->toBeBool()
            ->tobe($expected);
    })->with([
        'true' => [[4, 8, 12, 16], [2, 4, 6, 8, 10, 12, 14, 16, 18], true],
        'false' => [[2, 3, 5, 7, 11, 13, 17, 19], [3, 5, 7, 9, 11, 13, 15, 17, 19], false],
        'same' => [[1, 2, 3], [1, 2, 3], true],
    ]);

    it('superset', function (array $a, array $b, bool $expected) {
        $set_a = new Set($a);
        $set_b = new Set($b);

        expect($set_a->isSupersetOf($set_b))
            ->toBeBool()
            ->tobe($expected);
    })->with([
        'true' => [[2, 4, 6, 8, 10, 12, 14, 16, 18], [4, 8, 12, 16], true],
        'false' => [[2, 3, 5, 7, 11, 13, 17, 19], [3, 5, 7, 9, 11, 13, 15, 17, 19], false],
        'same' => [[1, 2, 3], [1, 2, 3], true],
    ]);
});

describe('magic methods', function () {
    it('access a property', function () {
        $set = new Set();

        expect($set->size)
            ->toBe(0);
    });

    it('cannot access non existing property', function () {
        $set = new Set();

        /** @phpstan-ignore-line  */
        expect(fn () => $set->length)->toThrow(
            exception: InvalidArgumentException::class,
            exceptionMessage: 'Undefined property: length',
        );
    });

    it('cannot mutable private property', function () {
        $set = new Set();

        expect(fn () => $set->size = 1)->toThrow(
            exception: InvalidArgumentException::class,
            exceptionMessage: 'Property [size] is immutable',
        );
    });

    it('check a property exists', function (string $name, bool $expected) {
        $set = new Set();

        expect(isset($set->{$name}))
            ->toBe($expected);
    })->with([
        ['size', false],
        ['length', true],
    ]);
});
