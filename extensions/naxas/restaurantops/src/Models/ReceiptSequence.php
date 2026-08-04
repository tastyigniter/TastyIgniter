<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class ReceiptSequence extends Model
{
    protected $table = 'naxas_restaurant_ops_receipt_sequences';

    protected $guarded = ['id'];

    protected $casts = ['sequence_date' => 'date', 'next_value' => 'integer'];
}
