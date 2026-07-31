<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class MenuModifierGroup extends Model
{
    protected $table = 'naxas_restaurant_ops_menu_modifier_groups';

    protected $guarded = [];

    protected $casts = ['menu_id' => 'integer', 'variant_id' => 'integer', 'modifier_group_id' => 'integer', 'required_override' => 'boolean', 'min_override' => 'integer', 'max_override' => 'integer', 'free_quantity_override' => 'integer', 'is_active' => 'boolean'];
}
