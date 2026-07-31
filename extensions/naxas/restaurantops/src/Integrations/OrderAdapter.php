<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\Cart\Models\Order;

final class OrderAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return Order::class;
    }
}
