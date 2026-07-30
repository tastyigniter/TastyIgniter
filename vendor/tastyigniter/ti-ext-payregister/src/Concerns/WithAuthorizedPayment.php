<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Concerns;

use Igniter\Cart\Models\Order;
use LogicException;

trait WithAuthorizedPayment
{
    public function shouldAuthorizePayment()
    {
        throw new LogicException('Method shouldAuthorizePayment must be implemented on your custom payment class.');
    }

    public function shouldCapturePayment(Order $order): bool
    {
        return $this->model->capture_status == $order->status_id;
    }

    public function captureAuthorizedPayment(Order $order)
    {
        throw new LogicException('Method captureAuthorizedPayment must be implemented on your custom payment class.');
    }

    public function cancelAuthorizedPayment(Order $order)
    {
        throw new LogicException('Method cancelAuthorizedPayment must be implemented on your custom payment class.');
    }
}
