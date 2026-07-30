<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal;

/**
 * A handy interface for getting at include parameters.
 */
class ParamBag implements \ArrayAccess, \IteratorAggregate
{
    protected array $params = [];

    /**
     * Create a new parameter bag instance.
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get parameter values out of the bag.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function get(string $key)
    {
        return $this->__get($key);
    }

    /**
     * Get parameter values out of the bag via the property access magic method.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function __get(string $key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    /**
     * Check if a param exists in the bag via an isset() check on the property.
     */
    public function __isset(string $key): bool
    {
        return isset($this->params[$key]);
    }

    /**
     * Disallow changing the value of params in the data bag via property access.
     *
     * @param mixed  $value
     *
     * @throws \LogicException
     */
    public function __set(string $key, $value): void
    {
        throw new \LogicException('Modifying parameters is not permitted');
    }

    /**
     * Disallow unsetting params in the data bag via property access.
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function __unset(string $key): void
    {
        throw new \LogicException('Modifying parameters is not permitted');
    }

    /**
     * Check if a param exists in the bag via an isset() and array access.
     *
     * @param string $key
     */
    public function offsetExists($key): bool
    {
        return $this->__isset($key);
    }

    /**
     * Get parameter values out of the bag via array access.
     *
     * @param string $key
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return $this->__get($key);
    }

    /**
     * Disallow changing the value of params in the data bag via array access.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @throws \LogicException
     */
    public function offsetSet($key, $value): void
    {
        throw new \LogicException('Modifying parameters is not permitted');
    }

    /**
     * Disallow unsetting params in the data bag via array access.
     *
     * @param string $key
     *
     * @throws \LogicException
     */
    public function offsetUnset($key): void
    {
        throw new \LogicException('Modifying parameters is not permitted');
    }

    /**
     * IteratorAggregate for iterating over the object like an array.
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->params);
    }
}
