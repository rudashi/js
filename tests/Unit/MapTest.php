<?php

declare(strict_types=1);

use Pest\Expectation;
use Rudashi\JavaScript\Map;
use Rudashi\JavaScript\MapIterator;
use Tests\Fixtures\TraversableObject;

covers(Map::class);

describe('size property', function () {
    it('has fixed value on create', function () {
        $map = new Map(['foo' => 'bar']);

        expect($map->size)
            ->toBe(1);
    });

    it('increases when more elements', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->size)
            ->toBe(3);

        $map->set(null, 'baz');

        expect($map->size)
            ->toBe(4);
    });

    it('does not change when updating element', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->size)
            ->toBe(3);

        $map->set('foo', 'foo');

        expect($map->size)
            ->toBe(3);
    });

    it('decreases when fewer elements', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->size)
            ->toBe(3);

        $map->delete('foo');

        expect($map->size)
            ->toBe(2);
    });
});

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
        $map = callReflectMethod(new Map(), 'getArrayItems', new TraversableObject($items));

        expect($map)
            ->toBeArray()
            ->toMatchArray($items);
    });

    test('array', function () {
        $array = ['foo' => 'bar'];
        $map = callReflectMethod(new Map(), 'getArrayItems', $array);

        expect($map)
            ->toBeArray()
            ->toMatchArray($array);
    });

    test('object', function () {
        $object = [new stdClass];
        $map = callReflectMethod(new Map(), 'getArrayItems', $object);

        expect($map)
            ->toBeArray()
            ->toMatchArray($object);
    });

    test('string', function () {
        $string = ['foo'];
        $map = callReflectMethod(new Map(), 'getArrayItems', $string);

        expect($map)
            ->toBeArray()
            ->toMatchArray($string);
    });

    test('null', function () {
        $null = [null];
        $map = callReflectMethod(new Map(), 'getArrayItems', $null);

        expect($map)
            ->toBeArray()
            ->toMatchArray($null);
    });
});

describe('clear', function () {
    test('removes all elements', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        $map->clear();

        expect($map->size)
            ->tobe(0);
    });

    test('returns void', function () {
        $reflection = reflectMethod(Map::class, 'clear');

        expect($reflection->getReturnType())
            ->getName()->toBe('void');
    });
});

describe('delete', function () {
    test('returns true on success', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->delete('foo'))
            ->toBeTrue();
    });

    test('returns false on failure', function () {
        $map = new Map([1, 'foo' => 'bar', 3]);

        expect($map->delete('bar'))
            ->toBeFalse();
    });
});

describe('entries', function () {
    it('returns new MapIterator', function () {
        $map = new Map(['foo', 'bar']);

        $newMap = $map->entries();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe([0 => 'foo'])
            ->next()?->toBe([1 => 'bar']);
    });

    it('returns map elements', function () {
        $map = new Map(['foo' => 'bar', 'baz', '2' => 'boo']);

        $newMap = $map->entries();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe(['foo' => 'bar'])
            ->next()?->toBe([0 => 'baz'])
            ->next()?->toBe(['2' => 'boo']);
    });
});

describe('forEach', function () {
    test('iterate on every element', function () {
        $result = [];

        (new Map([2, 5, 9]))->forEach(function ($value, $key) use (&$result) {
            $result[$key] = $value * 2;
        });

        expect($result)
            ->toBeArray()
            ->toMatchArray([4, 10, 18]);
    });

    test('not change original map', function () {
        $result = [];

        $map = new Map([2, 5, 9]);
        $map->forEach(function ($value, $key) use (&$result) {
            $result[$key] = $value * 2;
        });

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([2, 5, 9]);
    });

    test('has access to Map inside loop', function () {
        $result = [];

        $map = new Map([2, 5, 9]);
        $map->forEach(function ($value, $key, $map) use (&$result) {
            $result[] = $map;
        });

        expect($result)
            ->toBeArray()
            ->sequence(fn (Expectation $item) => $item->toBeInstanceOf(Map::class));
    });

    test('can use arrow function', function () {
        $map = new Map();

        (new Map([2, 5, 9]))->forEach(fn ($value, $key) => $map->set($key, $value * 2));

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([4, 10, 18]);
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

describe('keys', function () {
    it('returns new MapIterator', function () {
        $map = new Map(['foo', 'bar']);

        $newMap = $map->keys();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe(0)
            ->next()?->toBe(1);
    });

    it('returns map keys', function () {
        $map = new Map(['foo' => 'bar']);

        $newMap = $map->keys();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe('foo');
    });
});

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

describe('values', function () {
    it('returns new MapIterator', function () {
        $map = new Map(['foo', 'bar']);

        $newMap = $map->values();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe('foo')
            ->next()?->toBe('bar');
    });

    it('returns map values', function () {
        $map = new Map(['foo' => 'bar']);

        $newMap = $map->values();

        expect($newMap)
            ->toBeInstanceOf(MapIterator::class)
            ->current()?->toBe('bar');
    });
});

describe('magic methods', function () {
    it('access a property', function () {
        $map = new Map();

        expect($map->size)
            ->toBe(0);
    });

    it('cannot access non existing property', function () {
        $map = new Map();

        /** @phpstan-ignore-line  */
        expect(fn () => $map->length)->toThrow(
            exception: InvalidArgumentException::class,
            exceptionMessage: 'Undefined property: length',
        );
    });

    it('cannot mutable private property', function () {
        $map = new Map();

        expect(fn () => $map->size = 1)->toThrow(
            exception: InvalidArgumentException::class,
            exceptionMessage: 'Property [size] is immutable',
        );
    });

    it('check a property exists', function (string $name, bool $expected) {
        $map = new Map();

        expect(isset($map->{$name}))
            ->toBe($expected);
    })->with([
        ['size', false],
        ['length', true],
    ]);
});
