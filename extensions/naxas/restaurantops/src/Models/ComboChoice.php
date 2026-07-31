<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ComboChoice extends Model
{
    protected $table = 'naxas_restaurant_ops_combo_choices';

    protected $guarded = [];

    protected $casts = ['combo_group_id' => 'integer', 'menu_id' => 'integer', 'variant_id' => 'integer', 'is_fixed' => 'boolean', 'quantity' => 'integer', 'upgrade_surcharge' => 'decimal:4', 'display_order' => 'integer', 'is_active' => 'boolean'];
}
