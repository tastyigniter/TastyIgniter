<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Events;

use Igniter\Flame\Traits\EventDispatchable;
use Igniter\PayRegister\Models\PaymentLog;

class OrderBeforeRefundProcessedEvent
{
    /**
     * @var mixed
     */
    public $order;

    use EventDispatchable;

    public function __construct(public PaymentLog $paymentLog)
    {
        $this->order = $paymentLog->order;
    }

    public static function eventName(): string
    {
        return 'admin.order.beforeRefundProcessed';
    }
}
