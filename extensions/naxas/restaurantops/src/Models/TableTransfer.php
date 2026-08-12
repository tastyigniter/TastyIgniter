<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class TableTransfer extends Model { protected $table = 'naxas_restaurant_ops_table_transfers'; public $guarded = []; protected $casts = ['transferred_at' => 'datetime']; }
