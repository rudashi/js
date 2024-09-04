<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use Traversable;

/**
 * @template TKey of array-key
 * @template-covariant TValue
 */
final readonly class Map
{
    /**
     * @var array<TKey, TValue>
     */
    private array $items;

    /**
     * @param  object|string|array<TKey, TValue>|null|  $items
     */
    public function __construct(object|array|string|null $items = [])
    {
        $this->items = $this->getArrayItems($items);
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