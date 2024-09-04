<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use Traversable;

/**
 * @template TKey of array-key
 * @template-covariant TValue
 */
class Map
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $items = [];

    /**
     * @param  object|string|array<TKey, TValue>|null|  $items
     */
    public function __construct(object|array|string|null $items = [])
    {
        $this->items = $this->getArrayItems($items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    protected function getArrayItems($items): array
    {
        return match (true) {
            $items instanceof Traversable => iterator_to_array($items),
            default => (array) $items,
        };
    }
}