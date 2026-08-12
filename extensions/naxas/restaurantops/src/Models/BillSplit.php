<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class BillSplit extends Model { protected $table = 'naxas_restaurant_ops_bill_splits'; public $guarded = []; public $relation = ['hasMany' => ['items' => BillSplitItem::class]]; }
