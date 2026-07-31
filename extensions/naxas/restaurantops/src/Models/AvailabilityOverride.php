<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class AvailabilityOverride extends Model
{
    protected $table = 'naxas_restaurant_ops_availability_overrides';

    protected $guarded = [];

    protected $casts = ['location_id' => 'integer', 'menu_id' => 'integer', 'variant_id' => 'integer', 'modifier_group_id' => 'integer', 'modifier_id' => 'integer', 'is_available' => 'boolean', 'is_visible' => 'boolean', 'is_sellable' => 'boolean', 'price_override' => 'decimal:4', 'available_from' => 'datetime', 'available_until' => 'datetime'];
}
