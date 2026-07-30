<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Jobs;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Stripe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class ProcessStripeWebhookJob implements ShouldQueue
{
    public $model;

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected Payment $payment,
        protected string $eventName,
        protected array $payload,
    ) {}

    public function getMethod(): string
    {
        return 'handle'.Str::studly(str_replace('.', '_', $this->eventName));
    }

    public function handle(): void
    {
        $this->{$this->getMethod()}($this->payload);
    }

    protected function handlePaymentIntentSucceeded(array $payload)
    {
        $paymentObject = $payload['data']['object'];

        /** @var null|Order $order */
        $order = Order::find($paymentObject['metadata']['order_id'] ?? null);
        if (!$order) {
            return;
        }

        if ($order->isPaymentProcessed()) {
            $order->logPaymentAttempt('Payment already processed, skipping webhook', 0, [], $paymentObject);

            return;
        }

        $this->payment->applyGatewayClass();

        /** @var null|Stripe $gateway */
        $gateway = $this->payment->getGatewayObject();
        if (!$gateway instanceof Stripe) {
            return;
        }

        $intentId = $paymentObject['id'] ?? null;
        if (!$intentId) {
            $order->logPaymentAttempt('Payment verification failed: missing payment intent id', 0, [], $paymentObject);

            return;
        }

        $paymentIntent = $gateway->verifyPaymentIntentForOrder($order, $intentId);
        if (!$paymentIntent instanceof PaymentIntent) {
            $order->logPaymentAttempt('Payment verification failed via webhook', 0, [], $paymentObject);

            return;
        }

        $verifiedResponse = $paymentIntent->toArray();
        if ($paymentIntent->status === 'requires_capture') {
            $order->logPaymentAttempt('Payment authorized via webhook', 1, [], $verifiedResponse);
        } else {
            $order->logPaymentAttempt('Payment successful via webhook', 1, [], $verifiedResponse, true);
        }

        $order->updateOrderStatus($this->payment->order_status, ['notify' => false]);
        $order->markAsPaymentProcessed();
    }

    protected function handleCheckoutSessionCompleted(array $payload)
    {
        $sessionObject = $payload['data']['object'];

        /** @var null|Order $order */
        $order = Order::find($sessionObject['metadata']['order_id'] ?? null);
        if (!$order) {
            return;
        }

        $this->payment->applyGatewayClass();

        /** @var null|Stripe $gateway */
        $gateway = $this->payment->getGatewayObject();
        if (!$gateway instanceof Stripe) {
            return;
        }

        $sessionId = $sessionObject['id'] ?? null;
        if (!$sessionId) {
            $order->logPaymentAttempt('Payment verification failed: missing checkout session id', 0, [], $sessionObject);

            return;
        }

        $session = $gateway->verifyCheckoutSessionForOrder($order, $sessionId);
        if (!$session instanceof Session) {
            $order->logPaymentAttempt('Payment verification failed', 0, [], $sessionObject);

            return;
        }

        $paymentIntent = $session->payment_intent;
        $verifiedResponse = $paymentIntent->toArray();

        if (is_object($paymentIntent) && $paymentIntent->status === 'requires_capture') {
            $order->logPaymentAttempt('Payment authorized via webhook', 1, [], $verifiedResponse);
        } else {
            $order->logPaymentAttempt('Payment successful via webhook', 1, [], $verifiedResponse, true);
        }

        if (!$order->isPaymentProcessed()) {
            $order->updateOrderStatus($this->payment->order_status, ['notify' => false]);
            $order->markAsPaymentProcessed();
        }
    }
}
