<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosPaymentEvent extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_payment_events';

    protected $guarded = ['id'];

    protected $casts = ['payload' => 'array', 'occurred_at' => 'datetime'];
}
