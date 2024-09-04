<?php

declare(strict_types=1);

use Rudashi\JavaScript\Map;

describe('create', function () {
    it('map', function () {
        $map = new Map();

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([]);
    });

    it('map from array', function () {
        $array = [[ 1, 'one' ],[ 2, 'two' ]];
        $map = new Map($array);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray($array);
    });

    it('map from a string', function () {
        $string = 'foo';
        $map = new Map($string);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([$string]);
    });

    it('map from an object', function () {
        $object = new stdClass();
        $object->foo = 'bar';

        $map = new Map($object);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray(['foo' => 'bar']);
    });

    it('map from a null', function () {
        $map = new Map(null);

        expect($map)
            ->toBeInstanceOf(Map::class)
            ->toMatchArray([]);
    });
});