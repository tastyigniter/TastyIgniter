<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class RestaurantTable extends Model
{
    protected $table = 'naxas_restaurant_ops_tables';
    public $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'capacity' => 'integer', 'position_x' => 'integer', 'position_y' => 'integer', 'width' => 'integer', 'height' => 'integer', 'rotation' => 'integer', 'sort_order' => 'integer'];
    public $relation = ['belongsTo' => ['floor' => [Floor::class, 'foreignKey' => 'floor_id']], 'hasOne' => ['activeSession' => [TableSession::class, 'foreignKey' => 'active_table_id']]];
}
