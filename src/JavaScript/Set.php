<?php

declare(strict_types=1);

namespace Rudashi\JavaScript;

use Closure;
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
     * The items contained in the Set.
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
     * Removes all elements from the Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/clear
     */
    public function clear(): void
    {
        $this->items = [];
        $this->length = 0;
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
     * Returns a new Set containing elements in given Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/difference
     *
     * @param \Rudashi\JavaScript\Set<TValue> $other
     *
     * @return \Rudashi\JavaScript\Set<TValue>
     */
    public function difference(Set $other): Set
    {
        return new Set(array_diff($this->items, $other->items));
    }

    /**
     * Returns Set value of each element as SetIterator.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/entries
     *
     * @return \Rudashi\JavaScript\SetIterator<int, array{TValue, TValue}>
     */
    public function entries(): SetIterator
    {
        return new SetIterator(array_map(static fn ($item): array => [$item, $item], $this->items));
    }

    /**
     * Execute a callback over each item.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/forEach
     *
     * @param  \Closure(TValue, TValue, \Rudashi\JavaScript\Set<TValue>): void  $callback
     */
    public function forEach(Closure $callback): void
    {
        foreach ($this->items as $item) {
            $callback($item, $item, $this);
        }
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
     * Returns a new Set containing elements from both Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/intersection
     *
     * @param \Rudashi\JavaScript\Set<TValue> $other
     *
     * @return \Rudashi\JavaScript\Set<TValue>
     */
    public function intersection(Set $other): Set
    {
        return new Set(array_intersect($this->items, $other->items));
    }

    /**
     * Determine if all elements not exists in the given Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/isDisjointFrom
     *
     * @param  \Rudashi\JavaScript\Set<TValue>  $other
     */
    public function isDisjointFrom(Set $other): bool
    {
        foreach ($this->items as $value) {
            if ($other->has($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if all elements exists in the given Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/isSubsetOf
     *
     * @param \Rudashi\JavaScript\Set<TValue> $other
     */
    public function isSubsetOf(Set $other): bool
    {
        foreach ($this->items as $value) {
            if ($other->has($value) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if all elements of given Set exists in the Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/isSupersetOf
     *
     * @param \Rudashi\JavaScript\Set<TValue> $other
     */
    public function isSupersetOf(Set $other): bool
    {
        return $other->isSubsetOf($this);
    }

    /**
     * Returns Set keys as SetIterator.
     * Alias for the values()
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/keys
     *
     * @return \Rudashi\JavaScript\SetIterator<int, TValue>
     */
    public function keys(): SetIterator
    {
        return $this->values();
    }

    /**
     * Determine if all elements of given Set exists in the Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/symmetricDifference
     *
     * @param  \Rudashi\JavaScript\Set<TValue>  $other
     *
     * @return \Rudashi\JavaScript\Set<TValue>
     */
    public function symmetricDifference(Set $other): Set
    {
        return new Set([
            ...array_diff($this->items, $other->items),
            ...array_diff($other->items, $this->items),
        ]);
    }

    /**
     * @return array<int, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Merge the Set with the given Set.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/union
     *
     * @param \Rudashi\JavaScript\Set<TValue> $other
     *
     * @return \Rudashi\JavaScript\Set<TValue>
     */
    public function union(Set $other): Set
    {
        return new Set([...$this->items, ...$other->items]);
    }

    /**
     * Returns Set values as SetIterator.
     * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Set/values
     *
     * @return \Rudashi\JavaScript\SetIterator<int, TValue>
     */
    public function values(): SetIterator
    {
        return new SetIterator($this->items);
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
