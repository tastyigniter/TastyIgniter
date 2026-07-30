<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Models\Payment;

trait WithApplicableFee
{
    protected function validatePaymentMethod($order, $host)
    {
        $this->validateApplicableFee($order, $host);
    }

    protected function validateApplicableFee(Order $order, ?Payment $host = null)
    {
        $host ??= $this->model;

        $paymentMethod = $order->payment_method;
        if (!$paymentMethod || $paymentMethod->code != $host->code) {
            throw new ApplicationException('Payment method not found');
        }

        if (!$this->isApplicable($order->order_total, $host)) {
            throw new ApplicationException(sprintf(
                lang('igniter.payregister::default.alert_min_order_total'),
                currency_format($host->order_total), $host->name,
            ));
        }
    }

    /**
     * Returns true if the payment type is applicable for a specified order amount
     */
    public function isApplicable(float $total, ?Payment $host = null): bool
    {
        $host ??= $this->model;

        return $host->order_total <= $total;
    }

    /**
     * Returns true if the payment type has additional fee
     */
    public function hasApplicableFee(?Payment $host = null): bool
    {
        $host ??= $this->model;

        return ($host->order_fee ?? 0) > 0;
    }

    /**
     * Returns the payment type additional fee
     */
    public function getFormattedApplicableFee(?Payment $host = null): string
    {
        $host ??= $this->model;

        return ((int)$host->order_fee_type === 2)
            ? $host->order_fee.'%'
            : currency_format($host->order_fee);
    }
}
