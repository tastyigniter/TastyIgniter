<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class TableSession extends Model
{
    protected $table = 'naxas_restaurant_ops_table_sessions';
    public $guarded = [];
    protected $casts = ['opened_at' => 'datetime', 'closed_at' => 'datetime', 'guest_count' => 'integer', 'version' => 'integer'];
    public $relation = ['belongsTo' => ['table' => [RestaurantTable::class, 'foreignKey' => 'table_id'], 'posOrder' => [PosOrder::class, 'foreignKey' => 'pos_order_id']], 'hasMany' => ['events' => TableSessionEvent::class, 'transfers' => TableTransfer::class, 'splits' => BillSplit::class]];
}
