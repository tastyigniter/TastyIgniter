<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class Combo extends Model
{
    protected $table = 'naxas_restaurant_ops_combos';

    protected $guarded = [];

    protected $casts = ['menu_id' => 'integer', 'is_active' => 'boolean', 'version' => 'integer', 'archived_at' => 'datetime'];
}
