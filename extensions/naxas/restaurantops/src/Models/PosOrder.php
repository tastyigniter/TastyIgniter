<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosOrder extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_orders';

    public $guarded = [];

    protected $casts = ['delivery_address_snapshot' => 'array', 'requested_time' => 'datetime', 'held_at' => 'datetime', 'recalled_at' => 'datetime', 'kitchen_ready_at' => 'datetime', 'payment_locked_at' => 'datetime', 'cancelled_at' => 'datetime', 'version' => 'integer'];

    public $relation = ['hasMany' => ['items' => PosOrderItem::class, 'events' => PosOrderEvent::class, 'approvals' => PosApprovalRequest::class], 'belongsTo' => ['shift' => CashierShift::class]];
}
