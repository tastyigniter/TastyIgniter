<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ModifierCondition extends Model
{
    protected $table = 'naxas_restaurant_ops_modifier_conditions';

    protected $guarded = [];

    protected $casts = ['parent_modifier_id' => 'integer', 'child_group_id' => 'integer', 'expected_selected' => 'boolean'];
}
