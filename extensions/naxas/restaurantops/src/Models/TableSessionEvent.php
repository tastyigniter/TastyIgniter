<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class TableSessionEvent extends Model
{
    protected $table = 'naxas_restaurant_ops_table_session_events';
    public $guarded = [];
    protected $casts = ['payload' => 'array', 'occurred_at' => 'datetime'];
}
