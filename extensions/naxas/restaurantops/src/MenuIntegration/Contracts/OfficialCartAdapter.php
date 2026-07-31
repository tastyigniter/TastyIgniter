<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration\Contracts;

interface OfficialCartAdapter
{
    public function add(array $resolved): array;
}
