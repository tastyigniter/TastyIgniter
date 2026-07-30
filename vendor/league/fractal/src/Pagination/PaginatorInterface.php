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
 * A common interface for paginators to use
 *
 * @author Marc Addeo <marcaddeo@gmail.com>
 */
interface PaginatorInterface
{
    /**
     * Get the current page.
     */
    public function getCurrentPage(): int;

    /**
     * Get the last page.
     */
    public function getLastPage(): int;

    /**
     * Get the total.
     */
    public function getTotal(): int;

    /**
     * Get the count.
     */
    public function getCount(): int;

    /**
     * Get the number per page.
     */
    public function getPerPage(): int;

    /**
     * Get the url for the given page.
     */
    public function getUrl(int $page): string;
}
