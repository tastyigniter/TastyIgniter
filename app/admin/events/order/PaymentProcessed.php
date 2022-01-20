<?php

namespace Admin\Events\Order;

use System\Classes\BaseEvent;

class PaymentProcessed extends BaseEvent
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;

        $this->fireBackwardsCompatibleEvent('admin.order.paymentProcessed', [$this->order]);
    }
}
