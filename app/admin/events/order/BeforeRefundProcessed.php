<?php

namespace Admin\Events\Order;

use System\Classes\BaseEvent;

class BeforeRefundProcessed extends BaseEvent
{
    public $paymentLog;
    public $order;

    public function __construct($paymentLog)
    {
        $this->paymentLog = $paymentLog;
        $this->order = $paymentLog->order;

        $this->fireBackwardsCompatibleEvent('admin.order.beforePaymentProcessed', [$this->paymentLog]);
    }
}
