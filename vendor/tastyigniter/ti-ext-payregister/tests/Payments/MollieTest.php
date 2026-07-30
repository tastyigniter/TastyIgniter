<?php

declare(strict_types=1);

use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Payments\Mollie;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\Endpoints\CustomerEndpoint;
use Mollie\Api\Endpoints\PaymentEndpoint;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Customer as MollieCustomer;
use Mollie\Api\Resources\Payment as MolliePayment;

beforeEach(function(): void {
    $this->payment = Payment::factory()->create([
        'class_name' => Mollie::class,
    ]);
    $this->paymentLog = Mockery::mock(PaymentLog::class)->makePartial();
    $this->mollie = new Mollie($this->payment);
});

it('returns correct payment form view for mollie', function(): void {
    expect(Mollie::$paymentFormView)->toBe('igniter.payregister::_partials.mollie.payment_form');
});

it('returns correct fields config for mollie', function(): void {
    expect($this->mollie->defineFieldsConfig())->toBe('igniter.payregister::/models/mollie');
});

it('registers correct entry points for mollie', function(): void {
    $entryPoints = $this->mollie->registerEntryPoints();

    expect($entryPoints)->toBe([
        'mollie_return_url' => 'processReturnUrl',
        'mollie_notify_url' => 'processNotifyUrl',
    ]);
});

it('returns true if in mollie test mode', function(): void {
    $this->payment->transaction_mode = 'test';
    expect($this->mollie->isTestMode())->toBeTrue();
});

it('returns false if not in mollie test mode', function(): void {
    $this->payment->transaction_mode = 'live';

    expect($this->mollie->isTestMode())->toBeFalse();
});

it('returns mollie test API key in test mode', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_key';

    expect($this->mollie->getApiKey())->toBe('test_key');
});

it('returns mollie live API key in live mode', function(): void {
    $this->payment->transaction_mode = 'live';
    $this->payment->live_api_key = 'live_key';

    expect($this->mollie->getApiKey())->toBe('live_key');
});

it('processes mollie payment form and redirects to checkout url', function(): void {
    Mail::fake();
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    PaymentProfile::factory()->create([
        'customer_id' => $order->customer_id,
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => '123', 'customer_id' => '456'],
    ]);

    $molliePayment = Mockery::mock(MolliePayment::class);
    $molliePayment->shouldReceive('isOpen')->andReturn(true)->once();
    $molliePayment->shouldReceive('getCheckoutUrl')->andReturn('http://checkout.url')->once();
    $customerEndpoint = Mockery::mock(CustomerEndpoint::class);
    $customerEndpoint->shouldReceive('get')->andReturn(mock(MollieCustomer::class));
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('create')->andReturn($molliePayment)->once();
    $customerEndpoint->shouldReceive('create')->andReturn($mollieCustomer = mock(MollieCustomer::class))->once();
    $mollieCustomer->id = 'customer_id';
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    $mollieClient->customers = $customerEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $response = $this->mollie->processPaymentForm([], $this->payment, $order);

    expect($response->getTargetUrl())->toBe('http://checkout.url');
});

it('throws exception when fails to create payment profile', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    PaymentProfile::factory()->create([
        'customer_id' => $order->customer_id,
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => '123', 'customer_id' => '456'],
    ]);

    $customerEndpoint = Mockery::mock(CustomerEndpoint::class);
    $customerEndpoint->shouldReceive('get')->andReturn(mock(MollieCustomer::class));
    $customerEndpoint->shouldReceive('create')->andReturn(mock(MollieCustomer::class))->once();

    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->customers = $customerEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Unable to create customer');

    $response = $this->mollie->processPaymentForm([], $this->payment, $order);

    expect($response->getTargetUrl())->toBe('http://checkout.url');
});

it('throws exception if mollie payment creation fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $payment = Mockery::mock(MolliePayment::class);
    $payment->shouldReceive('isOpen')->andReturn(false)->once();
    $customerEndpoint = Mockery::mock(CustomerEndpoint::class);
    $customerEndpoint->shouldReceive('create')->andReturn((object)['id' => 'customer_id'])->once();
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('create')->andReturn($payment)->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    $mollieClient->customers = $customerEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->mollie->processPaymentForm([], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
    ]);
});

it('throws exception if mollie payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('create')->andThrow(new Exception('Payment error'))->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->mollie->processPaymentForm([], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
    ]);
});

it('processes mollie return url and updates order status', function(): void {
    request()->merge([
        'redirect' => 'http://redirect.url',
        'cancel' => 'http://cancel.url',
    ]);

    Mail::fake();
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $order->logPaymentAttempt('redirecting-to-payment-gateway', 0, [], [
        'id' => 'tr_test123',
        'status' => 'open',
    ]);

    $molliePayment = Mockery::mock(MolliePayment::class);
    $molliePayment->shouldReceive('isPaid')->andReturn(true)->once();
    $molliePayment->metadata = ['order_id' => $order->getKey()];
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->with('tr_test123')->andReturn($molliePayment)->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $response = $this->mollie->processReturnUrl([$order->hash]);

    expect($response->getTargetUrl())->toContain('http://redirect.url');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('redirects to the success page when the webhook already processed the payment', function(): void {
    request()->merge([
        'redirect' => 'http://redirect.url',
        'cancel' => 'http://cancel.url',
    ]);

    Mail::fake();
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $order->markAsPaymentProcessed();

    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->never();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $response = $this->mollie->processReturnUrl([$order->hash]);

    expect($response->getTargetUrl())->toContain('http://redirect.url');
});

it('redirects to cancel page when no payment attempt record exists', function(): void {
    request()->merge([
        'redirect' => 'http://redirect.url',
        'cancel' => 'http://cancel.url',
    ]);

    Mail::fake();
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $response = $this->mollie->processReturnUrl([$order->hash]);

    expect($response->getTargetUrl())->toContain('http://cancel.url')
        ->and(flash()->messages()->first())->message->toBe('Missing payment id in payment attempt records')->level->toBe('warning');
});

it('throws exception if no order found in mollie return url', function(): void {
    request()->merge([
        'redirect' => 'http://redirect.url',
        'cancel' => 'http://cancel.url',
    ]);

    $response = $this->mollie->processReturnUrl(['invalid_hash']);

    expect($response->getTargetUrl())->toContain('http://cancel.url')
        ->and(flash()->messages()->first())->message->not->toBeNull()->level->toBe('warning');
});

it('processes mollie notify url and updates order status', function(): void {
    request()->merge([
        'id' => 'payment_id',
    ]);

    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $molliePayment = Mockery::mock(MolliePayment::class);
    $molliePayment->shouldReceive('isPaid')->andReturn(true)->once();
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->andReturn($molliePayment)->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->setApiKey('test_'.str_random(30));

    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $response = $this->mollie->processNotifyUrl([$order->hash]);

    expect($response->getData())->success->toBe(true);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('processes mollie notify url fails and updates order status', function(): void {
    request()->merge([
        'id' => 'payment_id',
    ]);

    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->payment->applyGatewayClass();
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $molliePayment = Mockery::mock(MolliePayment::class);
    $molliePayment->shouldReceive('isPaid')->andReturn(false)->once();
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->andReturn($molliePayment)->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->setApiKey('test_'.str_random(30));

    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $response = $this->mollie->processNotifyUrl([$order->hash]);

    expect($response->getData())->success->toBe(true);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment unsuccessful',
        'is_success' => 0,
    ]);
});

it('throws exception if no order found in mollie notify url', function(): void {
    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No order found');

    $this->mollie->processNotifyUrl(['invalid_hash']);
});

it('processes mollie refund form and logs refund attempt', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->paymentLog->refunded_at = null;
    $this->paymentLog->response = ['status' => 'paid', 'id' => 'payment_id'];
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->paymentLog->shouldReceive('markAsRefundProcessed')->once();

    $molliePayment = Mockery::mock(MolliePayment::class);
    $molliePayment->shouldReceive('refund')->andReturn((object)[
        'id' => 'refund_id',
        'status' => 'refunded',
        'amount' => (object)['value' => '100.00', 'currency' => 'GBP'],
    ])->once();
    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->andReturn($molliePayment)->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $this->mollie->processRefundForm(['refund_type' => 'full'], $order, $this->paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => sprintf('Payment %s refund processed -> (%s: %s)', 'payment_id', 'full', 'refund_id'),
        'is_success' => 1,
    ]);
});

it('processes mollie refund request fails and logs refund attempt', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_api_key = 'test_'.str_random(30);
    $this->paymentLog->refunded_at = null;
    $this->paymentLog->response = ['status' => 'paid', 'id' => 'payment_id'];
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $paymentEndpoint = Mockery::mock(PaymentEndpoint::class);
    $paymentEndpoint->shouldReceive('get')->andThrow(new Exception('Refund Error'))->once();
    $mollieClient = Mockery::mock(MollieApiClient::class)->makePartial();
    $mollieClient->payments = $paymentEndpoint;
    app()->instance(MollieApiClient::class, $mollieClient);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Refund failed');

    $this->mollie->bindEvent('mollie.extendRefundFields', fn($fields, $order, $data): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->mollie->processRefundForm(['refund_type' => 'full'], $order, $this->paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Refund failed -> Refund Error',
        'is_success' => 1,
    ]);
});

it('throws exception if no mollie charge to refund', function(): void {
    $order = Order::factory()->create(['order_total' => 100]);
    $this->paymentLog->refunded_at = null;
    $this->paymentLog->response = ['status' => 'not_paid'];

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No charge to refund');

    $this->mollie->processRefundForm(['refund_type' => 'full'], $order, $this->paymentLog);
});
