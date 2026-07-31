<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class StaffPreference extends Model
{
    protected $table = 'naxas_restaurant_ops_staff_preferences';

    protected $guarded = [];

    protected $casts = ['staff_id' => 'integer', 'default_location_id' => 'integer'];
}
