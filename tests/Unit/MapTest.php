<?php

declare(strict_types=1);

use Rudashi\JavaScript\Map;
use Tests\Fixtures\TraversableObject;

describe('create', function () {
    test('map', function () {
        $map = new Map();

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([]);
    });

    test('map from array', function () {
        $array = [[1, 'one'], [2, 'two']];
        $map = new Map($array);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray($array);
    });

    test('map from a string', function () {
        $string = 'foo';
        $map = new Map($string);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([$string]);
    });

    test('map from an object', function () {
        $object = new stdClass();
        $object->foo = 'bar';

        $map = new Map($object);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray(['foo' => 'bar']);
    });

    test('map from a null', function () {
        $map = new Map(null);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([]);
    });
});

describe('getArrayItems', function () {
    test('Traversable', function () {
        $items = [new stdClass, new stdClass];
        $map = reflectMethod(new Map(), 'getArrayItems', new TraversableObject($items));

        expect($map)
            ->toBeArray()
            ->toMatchArray($items);
    });

    test('array', function () {
        $array = ['foo' => 'bar'];
        $map = reflectMethod(new Map(), 'getArrayItems', $array);

        expect($map)
            ->toBeArray()
            ->toMatchArray($array);
    });

    test('object', function () {
        $object = [new stdClass];
        $map = reflectMethod(new Map(), 'getArrayItems', $object);

        expect($map)
            ->toBeArray()
            ->toMatchArray($object);
    });

    test('string', function () {
        $string = ['foo'];
        $map = reflectMethod(new Map(), 'getArrayItems', $string);

        expect($map)
            ->toBeArray()
            ->toMatchArray($string);
    });

    test('null', function () {
        $null = [null];
        $map = reflectMethod(new Map(), 'getArrayItems', $null);

        expect($map)
            ->toBeArray()
            ->toMatchArray($null);
    });
});

describe('get', function () {
    it('returns value', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->get('foo'))
            ->toBe('bar');
    });

    it('returns value based on index', function () {
        $map = new Map([1, 2, 3]);

        expect($map->get(2))
            ->toBe(3);
    });

    it('returns null', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->get(2))
            ->toBeNull();
    });

    it('returns null when null', function () {
        $map = new Map([1, 2, 3]);

        expect($map->get(null))
            ->toBeNull();
    });
});

test('has', function (mixed $key, bool $expected) {
    $map = new Map([1, 'foo' => 'bar', 3]);

    expect($map->has($key))
        ->toBe($expected);
})->with([
    [0, true],
    ['foo', true],
    [1, true],
    ['1', true],
    [2, false],
    [3, false],
    [null, false],
]);

describe('set', function () {
    it('adds entry', function () {
        $map = new Map();

        $map->set('foo', 'bar');

        expect($map->get('foo'))
            ->toBe('bar');
    });

    it('adds nested entry', function () {
        $map = new Map();

        $map->set('foo', ['nested' => 'bar']);

        expect($map->get('foo'))
            ->toBe(['nested' => 'bar']);
    });

    it('adds only value', function () {
        $map = new Map();

        $map->set(null, 'bar');

        expect($map->get(0))
            ->toBe('bar');
    });

    it('update entry', function () {
        $map = new Map(['foo' => 'bar']);

        $map->set('foo', 'baz');

        expect($map->get('foo'))
            ->toBe('baz');
    });

    it('can chaining', function () {
        $map = new Map();

        $map->set('foo', 'bar')->set(1, 'foobar')->set(2, 'baz');

        expect($map)
            ->get('foo')?->toBe('bar')
            ->get(1)?->toBe('foobar')
            ->get(2)?->toBe('baz');
    });
});