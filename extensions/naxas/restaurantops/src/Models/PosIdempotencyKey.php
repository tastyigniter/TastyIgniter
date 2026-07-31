<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosIdempotencyKey extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_idempotency_keys';

    public $guarded = [];

    protected $casts = ['response_payload' => 'array'];
}
