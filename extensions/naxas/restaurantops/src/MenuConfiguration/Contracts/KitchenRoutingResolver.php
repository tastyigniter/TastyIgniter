<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration\Contracts;

interface KitchenRoutingResolver
{
    /** Returns preparation-facing names, station IDs and visibility; never dispatches tickets. */
    public function resolve(array $configuration): array;
}
