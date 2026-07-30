<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Concerns;

use Igniter\Cart\Classes\OrderTypes;
use Igniter\Local\Models\Location;
use Igniter\PayRegister\Models\Payment;
use Igniter\System\Actions\ModelAction;
use Illuminate\Support\Collection;

class LocationAction extends ModelAction
{
    public function allowGuestOrder(): bool
    {
        if (($allowGuestOrder = (int)$this->model->getSettings('checkout.guest_order', -1)) === -1) {
            $allowGuestOrder = (int)setting('guest_order', 1);
        }

        return (bool)$allowGuestOrder;
    }

    public function listAvailablePayments(): Collection
    {
        $result = [];

        $payments = $this->model->getSettings('checkout.payments', []);
        foreach (Payment::listPayments() as $payment) {
            if ($payments && !in_array($payment->code, $payments)) {
                continue;
            }

            $result[$payment->code] = $payment;
        }

        return collect($result);
    }

    public function availableOrderTypes(): Collection
    {
        return resolve(OrderTypes::class)->makeOrderTypes($this->model);
    }

    public static function getOrderTypeOptions()
    {
        return collect(resolve(OrderTypes::class)->listOrderTypes())->pluck('name', 'code');
    }

    public function getOrderTimeInterval(string $orderType): int
    {
        return (int)$this->model->getSettings($orderType.'.time_interval', 15);
    }

    public function shouldAddLeadTime(string $orderType): bool
    {
        return (bool)$this->model->getSettings($orderType.'.add_lead_time', 0);
    }

    public function getOrderLeadTime(string $orderType): int
    {
        return (int)$this->model->getSettings($orderType.'.lead_time', 15);
    }

    public function getOrderTimeRestriction(string $orderType): int
    {
        return (int)$this->model->getSettings($orderType.'.time_restriction', 0);
    }

    public function getOrderCancellationTimeout(string $orderType): int
    {
        return (int)$this->model->getSettings($orderType.'.cancellation_timeout', 0);
    }

    public function getMinimumOrderTotal(string $orderType): float
    {
        return (float)$this->model->getSettings($orderType.'.min_order_amount', 0);
    }

    public function deliveryMinutes(): int
    {
        return (int)$this->model->getSettings('delivery.lead_time', 15);
    }

    public function collectionMinutes(): int
    {
        return (int)$this->model->getSettings('collection.lead_time', 15);
    }

    public function hasDelivery(): bool
    {
        return (bool)$this->model->getSettings('delivery.is_enabled', 1);
    }

    public function hasCollection(): bool
    {
        return (bool)$this->model->getSettings('collection.is_enabled', 1);
    }

    public function hasFutureOrder(?string $orderType = null): bool
    {
        return (bool)$this->model->getSettings(($orderType ?: Location::DELIVERY).'.future_orders.is_enabled', 0);
    }

    public function futureOrderDays(?string $orderType = null): int
    {
        return (int)$this->model->getSettings(($orderType ?: Location::DELIVERY).'.future_orders.days', 0);
    }

    public function minimumFutureOrderDays(?string $orderType = null): int
    {
        return (int)$this->model->getSettings(($orderType ?: Location::DELIVERY).'.future_orders.min_days', 0);
    }
}
