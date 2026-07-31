<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class CartIdempotency extends Model
{
    protected $table = 'naxas_restaurant_ops_cart_idempotency';

    protected $guarded = [];

    protected $casts = ['response' => 'array', 'expires_at' => 'datetime'];
}
