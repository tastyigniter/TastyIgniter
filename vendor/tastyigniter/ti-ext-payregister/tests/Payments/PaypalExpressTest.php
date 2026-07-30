<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\PayPalClient;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Payments\PaypalExpress;
use Igniter\User\Models\Customer;
use Illuminate\Http\Client\Response;
use Mockery;

beforeEach(function(): void {
    $this->payment = Payment::factory()->create([
        'class_name' => PaypalExpress::class,
    ]);
    $this->paypalExpress = new PaypalExpress($this->payment);
});

it('returns correct payment form view for paypal express', function(): void {
    expect(PaypalExpress::$paymentFormView)->toBe('igniter.payregister::_partials.paypalexpress.payment_form');
});

it('returns correct fields config for paypal express', function(): void {
    expect($this->paypalExpress->defineFieldsConfig())->toBe('igniter.payregister::/models/paypalexpress');
});

it('registers correct entry points for paypal express', function(): void {
    $entryPoints = $this->paypalExpress->registerEntryPoints();

    expect($entryPoints)->toBe([
        'paypal_return_url' => 'processReturnUrl',
        'paypal_cancel_url' => 'processCancelUrl',
    ]);
});

it('returns true if in sandbox mode for paypal express', function(): void {
    $this->payment->api_mode = 'sandbox';

    expect($this->paypalExpress->isSandboxMode())->toBeTrue();
});

it('returns false if not in sandbox mode for paypal express', function(): void {
    $this->payment->api_mode = 'live';

    expect($this->paypalExpress->isSandboxMode())->toBeFalse();
});

it('returns sandbox API username in sandbox mode for paypal express', function(): void {
    $this->payment->api_mode = 'sandbox';
    $this->payment->api_sandbox_user = 'sandbox_user';

    expect($this->paypalExpress->getApiUsername())->toBe('sandbox_user');
});

it('returns live API username in live mode for paypal express', function(): void {
    $this->payment->api_mode = 'live';
    $this->payment->api_user = 'live_user';

    expect($this->paypalExpress->getApiUsername())->toBe('live_user');
});

it('returns sandbox API password in sandbox mode for paypal express', function(): void {
    $this->payment->api_mode = 'sandbox';
    $this->payment->api_sandbox_pass = 'sandbox_pass';

    expect($this->paypalExpress->getApiPassword())->toBe('sandbox_pass');
});

it('returns live API password in live mode for paypal express', function(): void {
    $this->payment->api_mode = 'live';
    $this->payment->api_pass = 'live_pass';

    expect($this->paypalExpress->getApiPassword())->toBe('live_pass');
});

it('returns AUTHORIZE when api_action is authorization for paypal express', function(): void {
    $this->payment->api_action = 'authorization';

    expect($this->paypalExpress->getTransactionMode())->toBe('AUTHORIZE');
});

it('returns CAPTURE when api_action is not authorization for paypal express', function(): void {
    $this->payment->api_action = 'capture';

    expect($this->paypalExpress->getTransactionMode())->toBe('CAPTURE');
});

it('processes payment form and redirects to payer action url', function(): void {
    $this->payment->api_action = 'authorization';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('ok')->andReturn(true);
    $response->shouldReceive('json')->with('links', [])->andReturn([['rel' => 'payer-action', 'href' => 'http://payer.action.url']]);
    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('createOrder')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $result = $this->paypalExpress->processPaymentForm([], $this->payment, $order);

    expect($result->getTargetUrl())->toBe('http://payer.action.url');
});

it('throws exception when payment response is not successful', function(): void {
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('ok')->andReturn(false);
    $response->shouldReceive('json')->withNoArgs()->andReturn([])->once();
    $response->shouldReceive('json')->with('message')->andReturn('Payment error')->once();
    $response->shouldReceive('json')->with('links', [])->andReturn([['rel' => 'payer-action', 'href' => 'http://payer.action.url']]);
    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('createOrder')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->paypalExpress->processPaymentForm([], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
    ]);
});

it('throws exception when payment request fails', function(): void {
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('createOrder')->andThrow(new Exception('Payment error'));
    app()->instance(PayPalClient::class, $paypalClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->paypalExpress->processPaymentForm([], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
    ]);
});

it('processes paypal express return url and updates order status', function(string $transactionMode): void {
    request()->merge(['token' => 'test_token']);

    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('json')->withNoArgs()->andReturn([]);
    if ($transactionMode === 'CAPTURE') {
        $response->shouldReceive('json')->with('purchase_units.0.payments.captures.0.status')->andReturn('COMPLETED');
    } else {
        $response->shouldReceive('json')->with('purchase_units.0.payments.authorizations.0.status')->andReturn('CREATED');
    }

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('getOrder')->andReturn([
        'status' => 'APPROVED',
        'intent' => $transactionMode,
        'purchase_units' => [
            [
                'reference_id' => $order->hash,
                'amount' => [
                    'currency' => 'USD',
                    'value' => number_format($order->order_total, 2, '.', ''),
                ],
            ],
        ],
    ]);
    $paypalClient->shouldReceive('captureOrder')->andReturn($response);
    $paypalClient->shouldReceive('authorizeOrder')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $result = $this->paypalExpress->processReturnUrl([$order->hash]);

    expect($result->getTargetUrl())->toContain('http://localhost/checkout');
})->with([
    ['CAPTURE'],
    ['AUTHORIZE'],
]);

it('redirects to cancel when paypal order reference does not match', function(): void {
    request()->merge(['token' => 'test_token']);

    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('getOrder')->andReturn([
        'status' => 'APPROVED',
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'reference_id' => 'invalid_hash',
                'amount' => [
                    'currency' => 'USD',
                    'value' => number_format($order->order_total, 2, '.', ''),
                ],
            ],
        ],
    ]);
    app()->instance(PayPalClient::class, $paypalClient);

    $response = $this->paypalExpress->processReturnUrl([$order->hash]);

    expect($response->getTargetUrl())->toContain('http://localhost/checkout')
        ->and(flash()->messages()->first())->message->toContain('Order reference does not match');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Order reference does not match',
        'is_success' => 0,
    ]);
});

it('redirects to cancel when paypal payment amount does not match order total', function(): void {
    request()->merge(['token' => 'test_token']);

    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('getOrder')->andReturn([
        'status' => 'APPROVED',
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'reference_id' => $order->hash,
                'amount' => [
                    'currency' => 'USD',
                    'value' => '50.00',
                ],
            ],
        ],
    ]);
    app()->instance(PayPalClient::class, $paypalClient);

    $response = $this->paypalExpress->processReturnUrl([$order->hash]);

    expect($response->getTargetUrl())->toContain('http://localhost/checkout')
        ->and(flash()->messages()->first())->message->toContain('Payment amount does not match order total');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment amount does not match order total',
        'is_success' => 0,
    ]);
});

it('redirects to success without marking order paid when paypal capture is not completed', function(): void {
    request()->merge(['token' => 'test_token']);

    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('json')->withNoArgs()->andReturn([]);
    $response->shouldReceive('json')->with('purchase_units.0.payments.captures.0.status')->andReturn('PENDING');

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('getOrder')->andReturn([
        'status' => 'APPROVED',
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'reference_id' => $order->hash,
                'amount' => [
                    'currency' => 'USD',
                    'value' => number_format($order->order_total, 2, '.', ''),
                ],
            ],
        ],
    ]);
    $paypalClient->shouldReceive('captureOrder')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $result = $this->paypalExpress->processReturnUrl([$order->hash]);

    expect($result->getTargetUrl())->toContain('http://localhost/checkout');
    expect($order->fresh()->isPaymentProcessed())->toBeFalse();
    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
    ]);
});

it('redirects to success without marking order paid when paypal authorization is not created', function(): void {
    request()->merge(['token' => 'test_token']);

    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('json')->withNoArgs()->andReturn([]);
    $response->shouldReceive('json')->with('purchase_units.0.payments.authorizations.0.status')->andReturn('DENIED');

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('getOrder')->andReturn([
        'status' => 'APPROVED',
        'intent' => 'AUTHORIZE',
        'purchase_units' => [
            [
                'reference_id' => $order->hash,
                'amount' => [
                    'currency' => 'USD',
                    'value' => number_format($order->order_total, 2, '.', ''),
                ],
            ],
        ],
    ]);
    $paypalClient->shouldReceive('authorizeOrder')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $result = $this->paypalExpress->processReturnUrl([$order->hash]);

    expect($result->getTargetUrl())->toContain('http://localhost/checkout');
    expect($order->fresh()->isPaymentProcessed())->toBeFalse();
    $this->assertDatabaseMissing('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment authorized',
    ]);
});

it('throws exception when no order found in paypal express return url', function(): void {
    request()->merge([
        'redirect' => 'http://redirect.url',
        'cancel' => 'http://cancel.url',
    ]);

    $response = $this->paypalExpress->processReturnUrl(['invalid_hash']);

    expect($response->getTargetUrl())->toContain('http://cancel.url')
        ->and(flash()->messages()->first())->message->not->toBeNull()->level->toBe('warning');
});

it('processes paypal express cancel url and logs payment attempt', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->payment->applyGatewayClass();

    $result = $this->paypalExpress->processCancelUrl([$order->hash]);

    expect($result->getTargetUrl())->toContain('http://localhost/checkout');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment canceled by customer',
    ]);
});

it('throws exception if no order found in paypal express cancel url', function(): void {
    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No order found');

    $this->paypalExpress->processCancelUrl(['invalid_hash']);
});

it('processes paypal express refund form and logs refund attempt', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['purchase_units' => [['payments' => ['captures' => [['id' => 'payment_id', 'status' => 'COMPLETED']]]]]],
    ]);

    $response = Mockery::mock(Response::class);
    $response->shouldReceive('json')->with('id')->andReturn('refund_id');
    $response->shouldReceive('json')->withNoArgs()->andReturn([]);
    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('refundPayment')->andReturn($response);
    app()->instance(PayPalClient::class, $paypalClient);

    $this->paypalExpress->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => sprintf('Payment %s refund processed -> (%s: %s)', 'payment_id', 'full', 'refund_id'),
        'is_success' => 1,
    ]);
});

it('throws exception when refund payment request fails', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['purchase_units' => [['payments' => ['captures' => [['id' => 'paypal_order_id', 'status' => 'COMPLETED']]]]]],
    ]);

    $paypalClient = Mockery::mock(PayPalClient::class)->makePartial();
    $paypalClient->shouldReceive('refundPayment')->andThrow(new Exception('Refund Error'));
    app()->instance(PayPalClient::class, $paypalClient);
    $this->paypalExpress->bindEvent('paypalexpress.extendRefundFields', fn($fields, $order, $data): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Refund failed');

    $this->paypalExpress->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Refund failed -> Refund Error',
        'is_success' => 1,
    ]);
});

it('throws exception if no paypal express charge to refund', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['purchase_units' => [['payments' => ['captures' => [['status' => 'not_completed']]]]]],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No charge to refund');

    $this->paypalExpress->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);
});
