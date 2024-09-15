<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \IteratorAggregate<TKey, TValue>
 */
final class MapIterator implements IteratorAggregate
{
    /**
     * @param  array<TKey, TValue>  $items
     */
    public function __construct(
        private readonly array $items,
        private int $position = 0,
    ) {
    }

    /**
     * Returns next element.
     *
     * @return TValue|null
     */
    public function next(): mixed
    {
        ++$this->position;

        return $this->current();
    }

    /**
     * Returns current element.
     *
     * @return TValue|null
     */
    public function current(): mixed
    {
        return $this->items[$this->position] ?? null;
    }

    /**
     * Returns items.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Retrieve an external iterator.
     *
     * @return \ArrayIterator<TKey, TValue>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
