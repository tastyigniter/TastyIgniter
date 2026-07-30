<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Observers;

use Igniter\Cart\Models\Order;

class OrderObserver
{
    public function creating(Order $order): void
    {
        $order->forceFill([
            'hash' => $order->generateHash(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
