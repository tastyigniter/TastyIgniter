<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Payments;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Models\Payment;
use Override;

class Cod extends BasePaymentGateway
{
    public static ?string $paymentFormView = 'igniter.payregister::_partials.cod.payment_form';

    #[Override]
    public function defineFieldsConfig(): string
    {
        return 'igniter.payregister::/models/cod';
    }

    /**
     * @param array $data
     * @param Payment $host
     * @param Order $order
     *
     * @throws ApplicationException
     */
    #[Override]
    public function processPaymentForm($data, $host, $order): void
    {
        $this->validateApplicableFee($order, $host);

        $order->updateOrderStatus($host->order_status, ['notify' => false]);
        $order->markAsPaymentProcessed();
    }
}
