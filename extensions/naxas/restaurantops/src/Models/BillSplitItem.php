<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class BillSplitItem extends Model { protected $table = 'naxas_restaurant_ops_bill_split_items'; public $guarded = []; protected $casts = ['allocation_payload' => 'array']; }
