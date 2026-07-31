<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class OrderItemSnapshot extends Model
{
    public $timestamps = false;

    protected $table = 'naxas_restaurant_ops_order_item_snapshots';

    protected $guarded = [];

    protected $casts = ['order_id' => 'integer', 'order_menu_id' => 'integer', 'menu_id' => 'integer', 'location_id' => 'integer', 'schema_version' => 'integer', 'snapshot' => 'array', 'total_price' => 'decimal:4', 'created_at' => 'datetime'];
}
