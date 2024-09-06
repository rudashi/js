<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final readonly class TraversableObject implements IteratorAggregate
{
    public function __construct(
        private array $items
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}