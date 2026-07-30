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
 * A generic cursor adapter.
 *
 * @author Isern Palaus <ipalaus@ipalaus.com>
 * @author Michele Massari <michele@michelemassari.net>
 */
class Cursor implements CursorInterface
{
    /**
     * Current cursor value.
     *
     * @var mixed
     */
    protected $current;

    /**
     * Previous cursor value.
     *
     * @var mixed
     */
    protected $prev;

    /**
     * Next cursor value.
     *
     * @var mixed
     */
    protected $next;

    /**
     * Items being held for the current cursor position.
     */
    protected ?int $count;

    /**
     * Create a new Cursor instance.
     *
     * @param mixed $current
     * @param mixed $prev
     * @param mixed $next
     */
    public function __construct($current = null, $prev = null, $next = null, ?int $count = null)
    {
        $this->current = $current;
        $this->prev = $prev;
        $this->next = $next;
        $this->count = $count;
    }

    /**
     * {@inheritDoc}
     */
    #[\ReturnTypeWillChange]
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set the current cursor value.
     *
     * @param mixed $current
     */
    public function setCurrent($current): self
    {
        $this->current = $current;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    #[\ReturnTypeWillChange]
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * Set the prev cursor value.
     *
     * @param mixed $prev
     */
    public function setPrev($prev): self
    {
        $this->prev = $prev;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    #[\ReturnTypeWillChange]
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the next cursor value.
     *
     * @param mixed $next
     */
    public function setNext($next): self
    {
        $this->next = $next;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * Set the total items in the current cursor.
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
