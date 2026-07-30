<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Events;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Traits\EventDispatchable;
use Igniter\PayRegister\Models\PaymentLog;

class OrderRefundProcessedEvent
{
    use EventDispatchable;

    protected Order $order;

    public function __construct(public PaymentLog $paymentLog)
    {
        $this->order = $paymentLog->order;
    }

    public static function eventName(): string
    {
        return 'admin.order.refundProcessed';
    }
}
