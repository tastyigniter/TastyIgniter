<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Resource;

use ArrayIterator;
use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;

/**
 * Resource Collection
 *
 * The data can be a collection of any sort of data, as long as the
 * "collection" is either array or an object implementing ArrayIterator.
 */
class Collection extends ResourceAbstract
{
    /**
     * A collection of data.
     *
     * @var array|ArrayIterator
     */
    protected $data;

    protected ?PaginatorInterface $paginator = null;

    protected ?CursorInterface $cursor = null;

    public function getPaginator(): ?PaginatorInterface
    {
        return $this->paginator;
    }

    /**
     * Determine if the resource has a paginator implementation.
     */
    public function hasPaginator(): bool
    {
        return $this->paginator !== null;
    }

    /**
     * Get the cursor instance.
     */
    public function getCursor(): ?CursorInterface
    {
        return $this->cursor;
    }

    /**
     * Determine if the resource has a cursor implementation.
     */
    public function hasCursor(): bool
    {
        return $this->cursor !== null;
    }

    public function setPaginator(PaginatorInterface $paginator): self
    {
        $this->paginator = $paginator;

        return $this;
    }

    public function setCursor(CursorInterface $cursor): self
    {
        $this->cursor = $cursor;

        return $this;
    }
}
