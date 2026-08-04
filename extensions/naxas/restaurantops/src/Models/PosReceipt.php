<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosReceipt extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_receipts';

    protected $guarded = ['id'];

    protected $casts = ['location_snapshot' => 'array', 'cashier_snapshot' => 'array', 'customer_snapshot' => 'array', 'item_snapshot' => 'array', 'totals_snapshot' => 'array', 'tender_snapshot' => 'array', 'tax_snapshot' => 'array', 'footer_snapshot' => 'array', 'issued_at' => 'datetime', 'last_printed_at' => 'datetime', 'is_reversed' => 'boolean'];
}
