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

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * A paginator adapter for illuminate/pagination.
 *
 * @author Maxime Beaudoin <firalabs@gmail.com>
 * @author Marc Addeo <marcaddeo@gmail.com>
 */
class IlluminatePaginatorAdapter implements PaginatorInterface
{
    protected LengthAwarePaginator $paginator;

    /**
     * Create a new illuminate pagination adapter.
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return $this->paginator->total();
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->paginator->count();
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        return $this->paginator->perPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return $this->paginator->url($page);
    }

    /**
     * Get the paginator instance.
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }
}
