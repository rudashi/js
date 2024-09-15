<?php

declare(strict_types=1);

namespace Tests\JavaScript;

use Rudashi\JavaScript\MapIterator;

covers(MapIterator::class);

test('create MapIterator', function () {
    $iterator = new MapIterator([]);

    expect($iterator)
        ->toBeInstanceOf(MapIterator::class)
        ->toMatchArray([]);
});

describe('position', function () {
    test('default value', function () {
        $iterator = new MapIterator([]);
        $reflect = reflectProperty(MapIterator::class, 'position')->getValue($iterator);

        expect($reflect)
            ->toBeInt()
            ->toBe(0);
    });

    it('can increment', function () {
        $iterator = new MapIterator([]);
        $reflect = fn () => reflectProperty(MapIterator::class, 'position')->getValue($iterator);

        expect($reflect())->toBe(0);

        $iterator->next();

        expect($reflect())->toBe(1);
    });
});

test('loop MapIterator', function () {
    $iterator = new MapIterator(['1', '2', '3']);

    expect($iterator)->sequence(
        fn ($el) => $el->toBe('1'),
        fn ($el) => $el->toBe('2'),
        fn ($el) => $el->toBe('3'),
    );
});

test('get current element', function () {
    $iterator = new MapIterator(['1', '2', '3']);

    expect($iterator->current())
        ->toBe('1');
});

describe('next', function () {
    test('get next element', function () {
        $iterator = new MapIterator(['1', '2', '3']);

        expect($iterator)
            ->current()?->toBe('1')
            ->next()?->toBe('2')
            ->next()?->toBe('3');
    });

    test('increment position property', function () {
        $iterator = new MapIterator(['1', '2', '3']);

        expect($iterator)
            ->next()?->toBe('2')
            ->next()?->toBe('3');
    });
});

describe('toArray', function () {
    test('returns array', function () {
        $iterator = new MapIterator([]);

        expect($iterator->toArray())
            ->toBeArray()
            ->toBeEmpty()
            ->toBe([]);
    });

    test('returns array of elements', function () {
        $array = ['1', '2', '3'];

        $iterator = new MapIterator($array);

        expect($iterator->toArray())
            ->not->toBeEmpty()
            ->toBe($array);
    });
});
