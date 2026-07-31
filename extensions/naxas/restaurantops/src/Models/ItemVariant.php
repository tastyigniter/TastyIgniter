<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ItemVariant extends Model
{
    protected $table = 'naxas_restaurant_ops_item_variants';

    protected $guarded = [];

    protected $casts = ['menu_id' => 'integer', 'price_value' => 'decimal:4', 'cost' => 'decimal:4', 'is_default' => 'boolean', 'is_active' => 'boolean', 'display_order' => 'integer', 'version' => 'integer', 'archived_at' => 'datetime'];
}
