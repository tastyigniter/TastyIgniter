<?php

declare(strict_types=1);

namespace Igniter\Cart\Events;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Traits\EventDispatchable;

class OrderBeforePaymentProcessedEvent
{
    use EventDispatchable;

    public function __construct(public Order $order) {}

    public static function eventName(): string
    {
        return 'admin.order.beforePaymentProcessed';
    }
}
