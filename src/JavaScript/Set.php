<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use Traversable;

/**
 * @template TValue
 */
final class Set
{
    /**
     * The items contained in the Map.
     *
     * @var array<int, TValue>
     */
    private array $items;

    /**
     * Create a new Set instance.
     *
     * @param  iterable<array-key, TValue>  $items
     */
    public function __construct(iterable $items = [])
    {
        $this->items = $this->unique($this->getArrayItems($items));
    }

    /**
     * Insert a new element into Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/add
     *
     * @param  TValue  $value
     *
     * @return \Rudashi\JavaScript\Set<TValue>
 */
    public function add(mixed $value): self
    {
        if (! $this->has($value)) {
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * Determine if an element with given value exists in the Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/has
     *
     * @param  TValue  $value
     */
    public function has(mixed $value): bool
    {
        return in_array($value, $this->items, true);
    }

    /**
     * @return array<int, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @param  iterable<array-key, TValue>  $items
     *
     * @return array<array-key, TValue>
     */
    private function getArrayItems(iterable $items): array
    {
        return match (true) { // @pest-mutate-ignore
            $items instanceof Traversable => iterator_to_array($items),
            default => $items,
        };
    }

    /**
     * @param  array<array-key, TValue>  $items
     *
     * @return array<int, TValue>
     */
    private function unique(array $items): array
    {
        $exists = [];

        return array_values(array_filter($items, static function ($item) use (&$exists): bool {
            if (in_array($id = $item, $exists, true)) {
                return false;
            }

            $exists[] = $id;

            return true;
        }));
    }
}
