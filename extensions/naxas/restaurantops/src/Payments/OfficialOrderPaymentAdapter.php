<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Models\Payment;
use Naxas\RestaurantOps\Models\PosPayment;
use Naxas\RestaurantOps\Payments\Contracts\OfficialPaymentAdapter;
use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;

final class OfficialOrderPaymentAdapter implements OfficialPaymentAdapter
{
    public function outstanding(int $orderId): string
    {
        $order = Order::findOrFail($orderId);
        if ($order->isPaymentProcessed()) {
            throw PaymentException::conflict('payment_official_already_processed', 'The official order is already processed.');
        }

        return number_format((float) $order->order_total, 4, '.', '');
    }

    public function synchronize(PosPayment $payment, array $safeSummary): string
    {
        $order = Order::query()->lockForUpdate()->findOrFail($payment->official_order_id);
        if ($order->processed) {
            throw PaymentException::conflict('payment_official_already_processed', 'The official order is already processed.');
        } $method = Payment::query()->where('code', config('restaurant-ops.payment.official_method', 'cod'))->where('status', 1)->first();
        if (! $method) {
            throw new PaymentException('payment_official_method_unavailable', 'Configured official offline payment method is unavailable.');
        } $reference = 'POS-'.$payment->getKey();
        $order->payment = $method->code;
        $order->saveQuietly();
        $order->logPaymentAttempt('RestaurantOps POS settlement', true, ['reference' => $reference], $safeSummary, false);
        if (! $order->markAsPaymentProcessed()) {
            throw new PaymentException('payment_official_sync_failed', 'Official payment processing failed.');
        } $order->updateOrderStatus(null, ['comment' => 'POS payment '.$reference, 'notify' => false]);

        return $reference;
    }

    public function supportsReversal(PosPayment $payment): bool
    {
        return false;
    }
}
