<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use InvalidArgumentException;
use Traversable;

/**
 * @template TValue
 *
 * @property int $size Number of elements in the Set.
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
     * Number of elements in the Set.
     */
    private int $length;

    /**
     * Create a new Set instance.
     *
     * @param  iterable<array-key, TValue>  $items
     */
    public function __construct(iterable $items = [])
    {
        $this->items = $this->unique($this->getArrayItems($items));
        $this->length = count($this->items);
    }

    /**
     * Dynamically access a property.
     */
    public function __get(string $name): int
    {
        if ($name === 'size') {
            return $this->length;
        }

        throw new InvalidArgumentException('Undefined property: ' . $name);
    }

    /**
     * Dynamically write value to property.
     */
    public function __set(string $name, mixed $value): void
    {
        throw new InvalidArgumentException('Property [' . $name . '] is immutable');
    }

    /**
     * Dynamically check a property exists.
     */
    public function __isset(string $name): bool
    {
        return isset($this->{$name});
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
            $this->incrementSize();
        }

        return $this;
    }

    /**
     * Remove a specified element from the Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/get
     *
     * @param  TValue  $value
     */
    public function delete(mixed $value): bool
    {
        if ($key = array_search($value, $this->items, true)) {
            unset($this->items[$key]);
            $this->decrementSize();

            return true;
        }

        return false;
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

    /**
     * Increment the Set size.
     */
    private function decrementSize(): void
    {
        --$this->length;
    }

    /**
     * Decrement the Set size.
     */
    private function incrementSize(): void
    {
        ++$this->length;
    }
}
