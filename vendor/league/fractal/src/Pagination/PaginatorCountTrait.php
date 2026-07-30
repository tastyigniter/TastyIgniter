<?php

namespace League\Fractal\Pagination;

trait PaginatorCountTrait
{
    /**
     * Safely get the count from an iterable
     */
    private function getIterableCount(iterable $iterable): int
    {
        if ($iterable instanceof \Traversable) {
            return $this->getTraversableCount($iterable);
        }

        return count($iterable);
    }

    /**
     * Safely get the count from a traversable
     */
    private function getTraversableCount(\Traversable $traversable): int
    {
        if ($traversable instanceof \Countable) {
            return count($traversable);
        }

        // Call the "count" method if it exists
        if (method_exists($traversable, 'count')) {
            return $traversable->count();
        }

        // If not, fall back to iterator_count and rewind if possible
        $count = iterator_count($traversable);
        if ($traversable instanceof \Iterator || $traversable instanceof \IteratorAggregate) {
            $traversable->rewind();
        }

        return $count;
    }

}
