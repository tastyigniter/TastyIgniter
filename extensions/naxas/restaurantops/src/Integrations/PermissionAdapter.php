<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Naxas\RestaurantOps\Support\PermissionDefinitions;

final class PermissionAdapter
{
    public function definitions(): array
    {
        return PermissionDefinitions::locationContext();
    }
}
