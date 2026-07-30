<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Pagination;

/**
 * A paginator adapter for PhalconPHP/pagination.
 *
 * @author Thien Tran <fcduythien@gmail.com>
 * @author Nikolaos Dimopoulos <nikos@phalconphp.com>
 */
class PhalconFrameworkPaginatorAdapter implements PaginatorInterface
{
    /**
     * A slice of the result set to show in the pagination
     */
    private \stdClass $paginator;

    public function __construct(\stdClass $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->current;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->last;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return $this->paginator->total_items;
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->paginator->total_pages;
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        // $this->paginator->items->count()
        // Because when we use raw sql have not this method
        return count($this->paginator->items);
    }

    /**
     * {@inheritDoc}
     */
    public function getNext(): int
    {
        return $this->paginator->next;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return (string) $page;
    }
}
