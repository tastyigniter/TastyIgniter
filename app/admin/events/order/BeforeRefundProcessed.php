<?php

namespace Admin\Events\Order;

class BeforeRefundProcessed
{
    public $order;

    public $paymentLog;

    public function __construct($paymentLog)
    {
        $this->order = $paymentLog->order;
        $this->paymentLog = $paymentLog;
    }
}
