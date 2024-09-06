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
