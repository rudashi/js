<?php

declare(strict_types=1);

namespace Tests\Unit;

use Rudashi\JavaScript\SetIterator;

covers(SetIterator::class);

test('create SetIterator', function () {
    $iterator = new SetIterator([]);

    expect($iterator)
        ->toBeInstanceOf(SetIterator::class)
        ->toMatchArray([]);
});

describe('position', function () {
    test('default value', function () {
        $iterator = new SetIterator([]);
        $reflect = reflectProperty(SetIterator::class, 'position')->getValue($iterator);

        expect($reflect)
            ->toBeInt()
            ->toBe(0);
    });

    it('can increment', function () {
        $iterator = new SetIterator([]);
        $reflect = fn () => reflectProperty(SetIterator::class, 'position')->getValue($iterator);

        expect($reflect())->toBe(0);

        $iterator->next();

        expect($reflect())->toBe(1);
    });
});

test('loop SetIterator', function () {
    $iterator = new SetIterator(['1', '2', '3']);

    expect($iterator)->sequence(
        fn ($el) => $el->toBe('1'),
        fn ($el) => $el->toBe('2'),
        fn ($el) => $el->toBe('3'),
    );
});

describe('current', function () {
    test('get current element', function () {
        $iterator = new SetIterator(['1', '2', '3']);

        expect($iterator->current())
            ->toBe('1');
    });

    test('get current array element', function () {
        $iterator = new SetIterator([['1', '1'], ['2', '2']]);

        expect($iterator->current())
            ->toBe(['1', '1']);
    });
});

describe('next', function () {
    test('get next element', function () {
        $iterator = new SetIterator(['1', '2', '3']);

        expect($iterator)
            ->current()?->toBe('1')
            ->next()?->toBe('2')
            ->next()?->toBe('3');
    });

    test('get next array element', function () {
        $iterator = new SetIterator([['1', '1'], ['2', '2'], ['3', '3']]);

        expect($iterator)
            ->current()?->toBe(['1', '1'])
            ->next()?->toBe(['2', '2'])
            ->next()?->toBe(['3', '3']);
    });

    test('increment position property', function () {
        $iterator = new SetIterator(['1', '2', '3']);

        expect($iterator)
            ->next()?->toBe('2')
            ->next()?->toBe('3');
    });
});

describe('toArray', function () {
    test('returns array', function () {
        $iterator = new SetIterator([]);

        expect($iterator->toArray())
            ->toBeArray()
            ->toBeEmpty()
            ->toBe([]);
    });

    test('returns array of elements', function () {
        $array = ['1', '2', '3'];

        $iterator = new SetIterator($array);

        expect($iterator->toArray())
            ->not->toBeEmpty()
            ->toBe($array);
    });
});
