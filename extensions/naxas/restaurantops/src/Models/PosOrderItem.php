<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosOrderItem extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_order_items';

    public $guarded = [];

    protected $casts = ['configuration_payload' => 'array', 'pricing_payload' => 'array', 'quantity' => 'integer', 'kitchen_sent_quantity' => 'integer', 'version' => 'integer'];

    public $relation = ['belongsTo' => ['pos_order' => PosOrder::class]];
}
