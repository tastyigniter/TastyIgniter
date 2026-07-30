<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Jobs;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Jobs\ProcessStripeWebhookJob;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Cod;
use Stripe\ApiRequestor as StripeApiRequestorAlias;
use Stripe\HttpClient\CurlClient;

beforeEach(function(): void {
    StripeApiRequestorAlias::setHttpClient($this->httpClient = mock(CurlClient::class)->makePartial());
});

function setupStripePaymentMethod(Order $order): void
{
    $order->payment_method->transaction_mode = 'test';
    $order->payment_method->test_secret_key = 'test_secret_key';
    $order->payment_method->applyGatewayClass();
}

function setupVerifiedPaymentIntent(CurlClient $httpClient, Order $order, string $intentId, string $status): void
{
    setupStripeRequest($httpClient, 'payment_intents/'.$intentId, [
        'id' => $intentId,
        'object' => 'payment_intent',
        'status' => $status,
        'amount' => (int)number_format($order->order_total, 2, '', ''),
        'metadata' => ['order_id' => (string)$order->order_id],
    ]);
}

function setupVerifiedCheckoutSession(CurlClient $httpClient, Order $order, string $sessionId, string $paymentIntentStatus = 'succeeded'): void
{
    setupStripeRequest($httpClient, 'checkout/sessions/'.$sessionId, [
        'id' => $sessionId,
        'object' => 'checkout.session',
        'status' => 'complete',
        'amount_total' => (int)number_format($order->order_total, 2, '', ''),
        'metadata' => ['order_id' => (string)$order->order_id],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => $paymentIntentStatus,
            'amount' => (int)number_format($order->order_total, 2, '', ''),
            'metadata' => ['order_id' => (string)$order->order_id],
        ],
    ]);
}

it('handles payment intent succeeded with valid order and successful status', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupVerifiedPaymentIntent($this->httpClient, $order, 'pi_test_123', 'succeeded');

    $payload = [
        'data' => [
            'object' => [
                'id' => 'pi_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment successful via webhook',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('handles payment intent succeeded with valid order and requires capture status', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupVerifiedPaymentIntent($this->httpClient, $order, 'pi_test_123', 'requires_capture');

    $payload = [
        'data' => [
            'object' => [
                'id' => 'pi_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'requires_capture',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment authorized via webhook',
        'is_success' => 1,
        'is_refundable' => 0,
    ]);
});

it('does not mark order as paid when payment intent verification fails', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_test_123', [
        'id' => 'pi_test_123',
        'object' => 'payment_intent',
        'status' => 'succeeded',
        'amount' => 9999,
        'metadata' => ['order_id' => (string)$order->order_id],
    ]);

    $payload = [
        'data' => [
            'object' => [
                'id' => 'pi_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment verification failed via webhook',
        'is_success' => 0,
        'is_refundable' => 0,
    ]);
    expect($order->fresh()->isPaymentProcessed())->toBeFalse();
});

it('skips processing when order is already processed', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe']);
    setupStripePaymentMethod($order);
    $order->markAsPaymentProcessed();

    $payload = [
        'data' => [
            'object' => [
                'id' => 'pi_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment already processed, skipping webhook',
        'is_success' => 0,
        'is_refundable' => 0,
    ]);
});

it('returns early when payment gateway is not stripe for payment intent succeeded', function(): void {
    $payment = Payment::factory()->create(['class_name' => Cod::class]);
    $order = Order::factory()->for($payment, 'payment_method')->create(['order_total' => 100]);

    $payload = [
        'data' => [
            'object' => [
                'id' => 'pi_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($payment, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment successful via webhook',
    ]);
    expect($order->fresh()->isPaymentProcessed())->toBeFalse();
});

it('logs failure when payment intent id is missing from webhook payload', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);

    $payload = [
        'data' => [
            'object' => [
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment verification failed: missing payment intent id',
        'is_success' => 0,
    ]);
});

it('does nothing when order is not found', function(): void {
    $payload = [
        'data' => [
            'object' => [
                'metadata' => ['order_id' => 123],
                'status' => 'succeeded',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob(mock(Payment::class), 'payment_intent.succeeded', $payload);
    $job->handle();

    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => 99999,
    ]);
});

it('handles checkout session completed with valid order and successful status', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupVerifiedCheckoutSession($this->httpClient, $order, 'cs_test_123');

    $payload = [
        'data' => [
            'object' => [
                'id' => 'cs_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment successful via webhook',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('handles checkout session completed with valid order and requires capture status', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupVerifiedCheckoutSession($this->httpClient, $order, 'cs_test_123', 'requires_capture');

    $payload = [
        'data' => [
            'object' => [
                'id' => 'cs_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment authorized via webhook',
        'is_success' => 1,
        'is_refundable' => 0,
    ]);
});

it('does not mark order as paid when checkout session verification fails', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupStripeRequest($this->httpClient, 'checkout/sessions/cs_test_123', [
        'id' => 'cs_test_123',
        'object' => 'checkout.session',
        'status' => 'complete',
        'amount_total' => 9999,
        'metadata' => ['order_id' => (string)$order->order_id],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => 'succeeded',
            'amount' => 9999,
            'metadata' => ['order_id' => (string)$order->order_id],
        ],
    ]);

    $payload = [
        'data' => [
            'object' => [
                'id' => 'cs_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment verification failed',
        'is_success' => 0,
        'is_refundable' => 0,
    ]);
    expect($order->fresh()->isPaymentProcessed())->toBeFalse();
});

it('handles checkout session completed and skips order status update when already processed', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);
    setupVerifiedCheckoutSession($this->httpClient, $order, 'cs_test_123');
    $order->markAsPaymentProcessed();

    $payload = [
        'data' => [
            'object' => [
                'id' => 'cs_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment successful via webhook',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
    expect($order->fresh()->isPaymentProcessed())->toBeTrue();
});

it('returns early when payment gateway is not stripe for checkout session completed', function(): void {
    $payment = Payment::factory()->create(['class_name' => Cod::class]);
    $order = Order::factory()->for($payment, 'payment_method')->create(['order_total' => 100]);

    $payload = [
        'data' => [
            'object' => [
                'id' => 'cs_test_123',
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($payment, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment successful via webhook',
    ]);
});

it('logs failure when checkout session id is missing from webhook payload', function(): void {
    $order = Order::factory()->create(['payment' => 'stripe', 'order_total' => 100]);
    setupStripePaymentMethod($order);

    $payload = [
        'data' => [
            'object' => [
                'metadata' => ['order_id' => $order->getKey()],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob($order->payment_method, 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->getKey(),
        'message' => 'Payment verification failed: missing checkout session id',
        'is_success' => 0,
    ]);
});

it('does nothing when order is not found for checkout session completed', function(): void {
    $payload = [
        'data' => [
            'object' => [
                'metadata' => ['order_id' => 99999],
                'status' => 'complete',
            ],
        ],
    ];

    $job = new ProcessStripeWebhookJob(mock(Payment::class), 'checkout.session.completed', $payload);
    $job->handle();

    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => 99999,
    ]);
});
