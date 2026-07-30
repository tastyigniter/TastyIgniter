<?php

namespace Mollie\Api\Resources;

use Iterator;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements IteratorAggregate<TKey, TValue>
 */
class LazyCollection implements IteratorAggregate
{
    /**
     * @var callable
     */
    private $source;

    /**
     * @param callable $source
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Get all items in the collection.
     *
     * @return array
     */
    public function all(): array
    {
        return iterator_to_array($this->getIterator());
    }

    /**
     * Get an item from the collection by key.
     *
     * @param TKey $key
     * @return TValue|null
     */
    public function get($key)
    {
        foreach ($this as $outerKey => $outerValue) {
            if ($outerKey == $key) {
                return $outerValue;
            }
        }

        return null;
    }

    /**
     * Run a filter over each of the items.
     *
     * @param (callable(TValue, TKey): bool)  $callback
     * @return self
     */
    public function filter(callable $callback): self
    {
        return new self(function () use ($callback) {
            foreach ($this as $key => $value) {
                if ($callback($value, $key)) {
                    yield $key => $value;
                }
            }
        });
    }

    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param (callable(TValue, TKey): bool)|null  $callback
     * @return TValue|null
     */
    public function first(?callable $callback = null)
    {
        $iterator = $this->getIterator();

        if (is_null($callback)) {
            if (! $iterator->valid()) {
                return null;
            }

            return $iterator->current();
        }

        foreach ($iterator as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Run a map over each of the items.
     *
     * @template TMapValue
     *
     * @param callable(TValue, TKey): TMapValue  $callback
     * @return static<TKey, TMapValue>
     */
    public function map(callable $callback): self
    {
        return new self(function () use ($callback) {
            foreach ($this as $key => $value) {
                yield $key => $callback($value, $key);
            }
        });
    }

    /**
     * Take the first {$limit} items.
     *
     * @param int $limit
     * @return static
     */
    public function take(int $limit): self
    {
        return new self(function () use ($limit) {
            $iterator = $this->getIterator();

            while ($limit--) {
                if (! $iterator->valid()) {
                    break;
                }

                yield $iterator->key() => $iterator->current();

                if ($limit) {
                    $iterator->next();
                }
            }
        });
    }

    /**
     * Determine if all items pass the given truth test.
     *
     * @param (callable(TValue, TKey): bool) $callback
     * @return bool
     */
    public function every(callable $callback): bool
    {
        $iterator = $this->getIterator();

        foreach ($iterator as $key => $value) {
            if (! $callback($value, $key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    /**
     * Get an iterator for the items.
     *
     * @return Iterator<TKey, TValue>
     */
    public function getIterator(): Iterator
    {
        return $this->makeIterator($this->source);
    }

    /**
     * Get an iterator for the given value.
     *
     * @template TIteratorKey of array-key
     * @template TIteratorValue
     *
     * @param IteratorAggregate<TIteratorValue>|(callable(): \Generator<TIteratorKey, TIteratorValue>)  $source
     * @return Iterator<TIteratorValue>
     */
    protected function makeIterator($source): Iterator
    {
        if ($source instanceof IteratorAggregate) {
            return $source->getIterator();
        }

        return $source();
    }
}
