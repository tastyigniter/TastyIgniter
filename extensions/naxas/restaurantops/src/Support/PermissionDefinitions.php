<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Support;

final class PermissionDefinitions
{
    public static function locationContext(): array
    {
        return [
            'Restaurant.LocationContext.Access' => ['label' => 'Access assigned locations', 'group' => 'Location operations'],
            'Restaurant.LocationContext.Switch' => ['label' => 'Switch active location', 'group' => 'Location operations'],
            'Restaurant.LocationContext.ViewAll' => ['label' => 'Use all-locations reporting mode', 'group' => 'Location operations'],
            'Restaurant.LocationContext.Manage' => ['label' => 'Manage location operations', 'group' => 'Location operations'],
        ];
    }
}
