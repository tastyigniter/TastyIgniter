<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Carbon\CarbonInterface;
use Naxas\RestaurantOps\MenuConfiguration\Support\Context;
use Naxas\RestaurantOps\Models\AvailabilityOverride;

final class AvailabilityResolver
{
    public function resolve(int $menuId, Context $context, array $target = [], ?CarbonInterface $at = null): array
    {
        $query = AvailabilityOverride::query()->where('location_id', $context->locationId)->where('menu_id', $menuId)
            ->where(fn ($q) => $q->whereNull('service_type')->orWhere('service_type', $context->serviceType))
            ->where(fn ($q) => $q->whereNull('channel')->orWhere('channel', $context->channel));
        foreach (['variant_id', 'modifier_group_id', 'modifier_id'] as $column) {
            $query->where($column, $target[$column] ?? null);
        }
        $at ??= now();
        $rows = $query->where(fn ($q) => $q->whereNull('available_from')->orWhere('available_from', '<=', $at))
            ->where(fn ($q) => $q->whereNull('available_until')->orWhere('available_until', '>=', $at))->get()
            ->sortBy(fn ($row): int => (int) ! is_null($row->service_type) + (int) ! is_null($row->channel));
        $result = ['is_available' => true, 'is_visible' => true, 'is_sellable' => true, 'price_override' => null, 'preparation_minutes' => null, 'kitchen_station_id' => null];
        foreach ($rows as $row) {
            foreach (array_keys($result) as $field) {
                if ($row->{$field} !== null) {
                    $result[$field] = $row->{$field};
                }
            }
        }
        $result['configuration_versions'] = $rows->map(fn ($row): array => [$row->getKey(), $row->updated_at?->getTimestamp()])->values()->all();

        return $result;
    }
}
