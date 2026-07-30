<?php

declare(strict_types=1);

namespace Igniter\Coupons\Models\Observers;

use Igniter\Cart\Models\Order;

class OrderObserver
{
    public function deleting(Order $order): void
    {
        $order->coupon_history()->delete();
    }
}
