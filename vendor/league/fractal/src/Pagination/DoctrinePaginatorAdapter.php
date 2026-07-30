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

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * A paginator adapter for doctrine pagination.
 *
 * @author Fraser Stockley <fraser.stockley@gmail.com>
 */
class DoctrinePaginatorAdapter implements PaginatorInterface
{
    use PaginatorCountTrait;

    /**
     * The paginator instance.
     * @var  Paginator
     */
    private $paginator;

    /**
     * The route generator.
     *
     * @var callable
     */
    private $routeGenerator;

    /**
     * Create a new DoctrinePaginatorAdapter.
     * @param Paginator $paginator
     * @param callable $routeGenerator
     *
     */
    public function __construct(Paginator $paginator, callable $routeGenerator)
    {
        $this->paginator = $paginator;
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return (int) ($this->paginator->getQuery()->getFirstResult() / $this->paginator->getQuery()->getMaxResults()) + 1;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return (int) ceil($this->getTotal() / $this->paginator->getQuery()->getMaxResults());
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return count($this->paginator);
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->getTraversableCount($this->paginator->getIterator());
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return call_user_func($this->getRouteGenerator(), $page);
    }

    /**
     * Get the route generator.
     */
    private function getRouteGenerator(): callable
    {
        return $this->routeGenerator;
    }
}
