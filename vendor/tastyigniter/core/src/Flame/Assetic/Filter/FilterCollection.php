<?php

declare(strict_types=1);

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2014 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Igniter\Flame\Assetic\Filter;

use ArrayIterator;
use Countable;
use Igniter\Flame\Assetic\Asset\AssetInterface;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * A collection of filters.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class FilterCollection implements Countable, FilterInterface, IteratorAggregate
{
    private array $filters = [];

    public function __construct($filters = [])
    {
        foreach ($filters as $filter) {
            $this->ensure($filter);
        }
    }

    /**
     * Checks that the current collection contains the supplied filter.
     *
     * If the supplied filter is another filter collection, each of its
     * filters will be checked.
     */
    public function ensure(FilterInterface $filter): void
    {
        if ($filter instanceof Traversable) {
            foreach ($filter as $f) {
                $this->ensure($f);
            }
        } elseif (!in_array($filter, $this->filters, true)) {
            $this->filters[] = $filter;
        }
    }

    public function all(): array
    {
        return $this->filters;
    }

    public function clear(): void
    {
        $this->filters = [];
    }

    #[Override]
    public function filterLoad(AssetInterface $asset): void
    {
        foreach ($this->filters as $filter) {
            $filter->filterLoad($asset);
        }
    }

    #[Override]
    public function filterDump(AssetInterface $asset): void
    {
        foreach ($this->filters as $filter) {
            $filter->filterDump($asset);
        }
    }

    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->filters);
    }

    #[Override]
    public function count(): int
    {
        return count($this->filters);
    }
}
