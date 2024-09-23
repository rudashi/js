<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use Rudashi\JavaScript\Set;
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

test('has', function (mixed $key, bool $expected) {
    $set = new Set([1, 'foo' => 'bar', 3]);

    expect($set->has($key))
        ->toBe($expected);
})->with([
    [0, false],
    ['foo', false],
    [1, true],
    ['1', false],
    [2, false],
    [3, true],
    [null, false],
    ['bar', true],
]);

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
