<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Listeners;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Stripe;

class UpdatePaymentIntentSessionOnCheckout
{
    public function handle(Order $order): void
    {
        if (!$order->payment_method instanceof Payment) {
            return;
        }

        $paymentGateway = $order->payment_method->getGatewayObject();
        if (!$paymentGateway instanceof Stripe) {
            return;
        }

        $paymentGateway->updatePaymentIntentSession($order);
    }
}
