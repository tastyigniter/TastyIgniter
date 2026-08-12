<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class Floor extends Model
{
    protected $table = 'naxas_restaurant_ops_floors';
    public $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];
    public $relation = ['hasMany' => ['tables' => [RestaurantTable::class, 'foreignKey' => 'floor_id']]];
}
