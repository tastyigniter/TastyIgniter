<?php

namespace Admin\Events\Order;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BeforePaymentProcessed
{
    use Dispatchable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}
