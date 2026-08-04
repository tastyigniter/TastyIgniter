<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosPaymentReversal extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_payment_reversals';

    protected $guarded = ['id'];

    protected $casts = ['requested_at' => 'datetime', 'decided_at' => 'datetime'];
}
