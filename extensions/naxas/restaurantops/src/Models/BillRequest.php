<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class BillRequest extends Model { protected $table = 'naxas_restaurant_ops_bill_requests'; public $guarded = []; protected $casts = ['requested_at' => 'datetime']; }
