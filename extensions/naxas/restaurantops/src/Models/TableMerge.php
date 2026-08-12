<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class TableMerge extends Model { protected $table = 'naxas_restaurant_ops_table_merges'; public $guarded = []; protected $casts = ['merged_at' => 'datetime']; }
