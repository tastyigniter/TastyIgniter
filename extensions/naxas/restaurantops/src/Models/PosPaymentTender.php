<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosPaymentTender extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_payment_tenders';

    protected $guarded = ['id'];

    protected $casts = ['metadata' => 'array', 'amount_received' => 'decimal:4', 'amount_applied' => 'decimal:4', 'change_amount' => 'decimal:4'];
}
