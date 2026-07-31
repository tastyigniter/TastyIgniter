<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Naxas\RestaurantOps\MenuConfiguration\Contracts\KitchenRoutingResolver;

final class DefaultKitchenRoutingResolver implements KitchenRoutingResolver
{
    public function resolve(array $configuration): array
    {
        $item = $configuration['item'] ?? [];
        $variant = $configuration['variant'] ?? [];

        return ['name' => $variant['kitchen_name'] ?? $item['kitchen_name'] ?? $variant['name'] ?? $item['name'] ?? '', 'station_id' => $variant['kitchen_station_id'] ?? $item['kitchen_station_id'] ?? null, 'show_on_kitchen' => (bool) ($configuration['show_on_kitchen'] ?? true), 'modifiers' => array_map(fn (array $modifier): array => ['name' => $modifier['kitchen_name'] ?? $modifier['name'] ?? '', 'station_id' => $modifier['kitchen_station_id'] ?? $variant['kitchen_station_id'] ?? $item['kitchen_station_id'] ?? null, 'visible' => (bool) ($modifier['kitchen_visible'] ?? true)], $configuration['modifiers'] ?? [])];
    }
}
