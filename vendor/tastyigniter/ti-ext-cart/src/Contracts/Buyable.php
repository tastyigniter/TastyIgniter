<?php

declare(strict_types=1);

namespace Igniter\Cart\Contracts;

interface Buyable
{
    /**
     * Get the identifier of the Buyable item.
     *
     * @param array $options
     *
     * @return int|string
     */
    public function getBuyableIdentifier();

    /**
     * Get the description or title of the Buyable item.
     *
     * @param array $options
     *
     * @return string
     */
    public function getBuyableName();

    /**
     * Get the price of the Buyable item.
     *
     * @param array $options
     *
     * @return float
     */
    public function getBuyablePrice();
}
