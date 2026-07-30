<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Models\Observers;

use Igniter\PayRegister\Models\Payment;

class PaymentObserver
{
    public function retrieved(Payment $payment): void
    {
        $payment->applyGatewayClass();

        if (is_array($payment->data)) {
            $payment->setRawAttributes(array_merge($payment->data, $payment->getAttributes()));
        }
    }

    public function saving(Payment $payment): void
    {
        if (!$payment->exists) {
            return;
        }

        $payment->data = $payment->purgeConfigFields();
    }
}
