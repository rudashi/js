<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use InvalidArgumentException;
use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @property int $size Number of elements in the Map.
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
     * Number of elements in the Map.
     */
    private int $length;

    /**
     * Create a new Map instance.
     *
     * @param  object|string|array<TKey, TValue>|null  $items
     */
    public function __construct(object|array|string|null $items = [])
    {
        $this->items = $this->getArrayItems($items);
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
     * Removes all elements from.
     */
    public function clear(): void
    {
        $this->items = [];
        $this->length = 0;
    }

    /**
     * Remove a specified element by a key.
     * * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map/get
     */
    public function delete(int|string $key): bool
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
            $this->decrementSize();

            return true;
        }

        return false;
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
     * Determine if an element with given key exists in the Map.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map/has
     */
    public function has(int|string|null $key): bool
    {
        return (bool) ($this->items[$key] ?? false);
    }

    /**
     * Adds or updates an element with a specified key and a value.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map/set
     *
     * @param  TValue  $value
     * @return self<TKey, TValue>
     */
    public function set(int|string|null $key, mixed $value): self
    {
        if ($key === null) {
            $this->items[] = $value;
            $this->incrementSize();
        } else {
            $this->items[$key] = $value;
        }

        return $this;
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
        return match (true) { // @pest-mutate-ignore
            $items instanceof Traversable => iterator_to_array($items),
            default => (array) $items,
        };
    }

    /**
     * Increment the Map size.
     */
    private function decrementSize(): void
    {
        --$this->length;
    }

    /**
     * Decrement the Map size.
     */
    private function incrementSize(): void
    {
        ++$this->length;
    }
}
