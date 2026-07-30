<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Listeners;

use Igniter\Admin\Models\StatusHistory;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Model;
use Igniter\PayRegister\Concerns\WithAuthorizedPayment;

class CaptureAuthorizedPayment
{
    public function handle(Model $order, StatusHistory $statusHistory): void
    {
        if (!$order instanceof Order || !$paymentMethod = $order->payment_method) {
            return;
        }

        if (!in_array(WithAuthorizedPayment::class, class_uses($paymentMethod->getGatewayClass()))) {
            return;
        }

        if (!$paymentMethod->shouldCapturePayment($order)) {
            return;
        }

        $paymentMethod->captureAuthorizedPayment($order);
    }
}
