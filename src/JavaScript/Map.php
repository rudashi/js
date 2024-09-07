<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use Traversable;

/**
 * @template TKey of array-key
 * @template-covariant TValue
 */
final class Map
{
    /**
     * The items contained in the Map.
     *
     * @var array<TKey, TValue>
     */
    private array $items;

    /**
     * Create a new Map instance.
     *
     * @param  object|string|array<TKey, TValue>|null  $items
     */
    public function __construct(object|array|string|null $items = [])
    {
        $this->items = $this->getArrayItems($items);
    }

    /**
     * Returns a specified element by a key.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map/get
     *
     * @return TValue|null
     */
    public function get(int|string|null $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return array<TKey, TValue>
     */
    private function getArrayItems(mixed $items): array
    {
        return match (true) {
            $items instanceof Traversable => iterator_to_array($items),
            default => (array) $items,
        };
    }
}
