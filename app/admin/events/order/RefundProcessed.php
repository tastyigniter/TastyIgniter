<?php

namespace Admin\Events\Order;

class RefundProcessed
{
    public $paymentLog;

    public $order;

    public function __construct($paymentLog)
    {
        $this->paymentLog = $paymentLog;
        $this->order = $paymentLog->order;
    }
}
