<?php

namespace Admin\Events\Order;

class PaymentProcessed
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}
