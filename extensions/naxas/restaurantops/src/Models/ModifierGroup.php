<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ModifierGroup extends Model
{
    protected $table = 'naxas_restaurant_ops_modifier_groups';

    protected $guarded = [];

    protected $casts = ['option_id' => 'integer', 'is_required' => 'boolean', 'min_selections' => 'integer', 'max_selections' => 'integer', 'free_quantity' => 'integer', 'allow_quantity' => 'boolean', 'is_active' => 'boolean', 'version' => 'integer', 'archived_at' => 'datetime'];
}
