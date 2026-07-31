<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ModifierMetadata extends Model
{
    protected $table = 'naxas_restaurant_ops_modifier_metadata';

    protected $guarded = [];

    protected $casts = ['option_value_id' => 'integer', 'price_adjustment' => 'decimal:4', 'min_quantity' => 'integer', 'max_quantity' => 'integer', 'allow_quantity' => 'boolean', 'is_default' => 'boolean', 'is_active' => 'boolean', 'is_sold_out' => 'boolean', 'version' => 'integer', 'archived_at' => 'datetime'];
}
