<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ComboGroup extends Model
{
    protected $table = 'naxas_restaurant_ops_combo_groups';

    protected $guarded = [];

    protected $casts = ['combo_id' => 'integer', 'is_required' => 'boolean', 'min_selections' => 'integer', 'max_selections' => 'integer', 'display_order' => 'integer'];
}
