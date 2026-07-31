<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class SnapshotFailure extends Model
{
    protected $table = 'naxas_restaurant_ops_snapshot_failures';

    protected $guarded = [];

    protected $casts = ['order_id' => 'integer', 'order_menu_id' => 'integer', 'snapshot' => 'array', 'attempts' => 'integer', 'last_attempt_at' => 'datetime'];
}
