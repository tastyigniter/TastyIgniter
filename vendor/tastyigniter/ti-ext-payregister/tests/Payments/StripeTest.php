<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Jobs\ProcessStripeWebhookJob;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Payments\Cod;
use Igniter\PayRegister\Payments\Stripe;
use Igniter\User\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Stripe\ApiRequestor as StripeApiRequestorAlias;
use Stripe\HttpClient\CurlClient;
use Stripe\StripeObject;

beforeEach(function(): void {
    $this->payment = Payment::factory()->create([
        'class_name' => Stripe::class,
    ]);
    $this->stripe = new Stripe($this->payment);
    StripeApiRequestorAlias::setHttpClient($this->httpClient = mock(CurlClient::class)->makePartial());
});

it('returns correct payment form view for stripe', function(): void {
    expect(Stripe::$paymentFormView)->toBe('igniter.payregister::_partials.stripe.payment_form');
});

it('returns correct fields config for stripe', function(): void {
    expect($this->stripe->defineFieldsConfig())->toBe('igniter.payregister::/models/stripe');
});

it('registers correct entry points for stripe', function(): void {
    $entryPoints = $this->stripe->registerEntryPoints();

    expect($entryPoints)->toBe([
        'stripe_webhook' => 'processWebhookUrl',
        'stripe_return_url' => 'processReturnUrl',
        'stripe_cancel_url' => 'processCancelUrl',
    ]);
});

it('returns hidden fields for stripe', function(): void {
    $hiddenFields = $this->stripe->getHiddenFields();

    expect($hiddenFields)->toHaveKeys(['stripe_payment_method', 'stripe_idempotency_key']);
});

it('returns correct stripe model value', function($attribute, $methodName, $mode, $value, $returnValue): void {
    $this->payment->transaction_mode = $mode;
    $this->payment->$attribute = $value;

    expect($this->stripe->$methodName())->toBe($returnValue);
})->with([
    ['transaction_mode', 'isTestMode', 'live', 'live', false],
    ['transaction_mode', 'isTestMode', 'test', 'test', true],
    ['live_publishable_key', 'getPublishableKey', 'live', 'client123', 'client123'],
    ['test_publishable_key', 'getPublishableKey', 'test', 'client123', 'client123'],
    ['test_secret_key', 'getSecretKey', 'test', 'test_secret_key', 'test_secret_key'],
    ['live_secret_key', 'getSecretKey', 'live', 'live_secret_key', 'live_secret_key'],
    ['test_webhook_secret', 'getWebhookSecret', 'test', 'test_webhook_secret', 'test_webhook_secret'],
    ['live_webhook_secret', 'getWebhookSecret', 'live', 'live_webhook_secret', 'live_webhook_secret'],
    ['transaction_type', 'shouldAuthorizePayment', 'test', 'auth_only', true],
    ['transaction_type', 'shouldAuthorizePayment', 'live', 'sale', false],
]);

it('adds correct js files for stripe payment form', function(): void {
    $controller = Mockery::mock(MainController::class);
    $controller->shouldReceive('addJs')->with('https://js.stripe.com/basil/stripe.js', 'stripe-js')->once();
    $controller->shouldReceive('addJs')->with('igniter.payregister::/js/process.stripe.js', 'process-stripe-js')->once();

    $this->stripe->beforeRenderPaymentForm($this->stripe, $controller);
});

it('returns true for completesPaymentOnClient for stripe', function(): void {
    expect($this->stripe->completesPaymentOnClient())->toBeTrue();
});

it('returns true for isOffsiteMode when offsite_enabled is set', function(): void {
    $this->payment->offsite_enabled = true;

    expect($this->stripe->completesPaymentOnClient())->toBeFalse()
        ->and($this->stripe->isOffsiteMode())->toBeTrue();
});

it('returns false for isOffsiteMode when offsite_enabled is not set', function(): void {
    $this->payment->offsite_enabled = false;

    expect($this->stripe->isOffsiteMode())->toBeFalse();

    $this->payment->offsite_enabled = null;

    expect($this->stripe->isOffsiteMode())->toBeFalse();
});

it('returns stripe js options with locale', function(): void {
    $order = Mockery::mock(Order::class);
    $this->payment->locale_code = 'en';

    Event::listen('payregister.stripe.extendJsOptions', fn($stripePayment, $options, $order): array => [
        'test_key' => 'test_value',
    ]);

    expect($this->stripe->getStripeJsOptions($order))->toBe([
        'locale' => 'en',
        'test_key' => 'test_value',
    ]);
});

it('returns stripe options with extended options', function(): void {
    Event::listen('payregister.stripe.extendOptions', fn($stripePayment, $options): array => [
        'test_key' => 'test_value',
    ]);

    expect($this->stripe->getStripeOptions())->toBe([
        'test_key' => 'test_value',
    ]);
});

it('creates stripe payment intent successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'customers', [
        'id' => 'cus_123',
    ], 'post');
    setupStripeRequest($this->httpClient, 'payment_intents', [
        'id' => 'pi_123',
        'client_secret' => 'secret',
    ], 'post');

    expect($this->stripe->createOrFetchIntent($order))->toBe('secret');
});

it('fetches & updates stripe payment intent successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123', [
        'id' => 'pi_123',
        'status' => 'not-succeeded',
    ]);
    setupStripeRequest($this->httpClient, 'payment_intents', [
        'id' => 'pi_123',
        'client_secret' => 'secret',
    ], 'post');

    expect($this->stripe->createOrFetchIntent($order))->toBe('secret');
});

it('returns null when payment is already processed in createOrFetchIntent', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create([
            'order_total' => 100,
            'processed' => 1,
        ]);
    $order->updateOrderStatus(1);

    $result = $this->stripe->createOrFetchIntent($order);
    expect($result)->toBeNull();
});

it('logs error and returns null when exception occurs in createOrFetchIntent', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $this->httpClient->shouldReceive('request')->andThrow(new Exception('Error'));

    expect($this->stripe->createOrFetchIntent($order))->toBeNull();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Creating checkout session failed: Error',
        'is_success' => 0,
    ]);
});

it('processes stripe payment form successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123', [
        'id' => 'pi_123',
        'status' => 'succeeded',
    ]);

    $data = [];
    $result = $this->stripe->processPaymentForm($data, $this->payment, $order);

    expect($result)->toBeTrue()
        ->and($this->stripe->getSession('ti_payregister_stripe_intent'))->toBeNull();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('returns true when payment is already processed in processPaymentForm', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create([
            'order_total' => 100,
            'processed' => 1,
        ]);
    $order->updateOrderStatus(1);

    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');

    $result = $this->stripe->processPaymentForm([], $this->payment, $order);
    expect($result)->toBeTrue();
});

it('throws exception if stripe payment intent id is missing in session', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->stripe->processPaymentForm([], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error: Missing payment intent identifier in session.',
        'is_success' => 0,
    ]);
});

it('logs error and throws exception when payment intent status is not succeeded', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123', [
        'id' => 'pi_123',
        'status' => 'not_succeeded',
    ]);

    $data = [];

    $result = $this->stripe->processPaymentForm($data, $this->payment, $order);

    expect($result)->toBeTrue();
});

it('updates payment profile on process payment form success', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123', [
        'id' => 'pi_123',
        'status' => 'requires_capture',
        'payment_method' => [
            'id' => 'pm_123',
            'card' => StripeObject::constructFrom(['brand' => 'Visa', 'last4' => '4242']),
        ],
    ]);

    $this->stripe->processPaymentForm([
        'create_payment_profile' => 1,
    ], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment authorized',
        'is_success' => 1,
        'is_refundable' => 0,
    ]);
});

it('captures authorized payment successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123/capture', [
        'id' => 'pi_123',
        'status' => 'succeeded',
    ], 'post');

    $this->stripe->bindEvent('stripe.extendCaptureFields', fn($data, $order): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->stripe->captureAuthorizedPayment($order, []);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('throws exception when no successful authorized payment to capture', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 0,
        'response' => ['id' => 'pi_123'],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No successful authorized payment to capture');

    $this->stripe->captureAuthorizedPayment($order, []);
});

it('throws exception when payment intent id is missing in payment response', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['status' => 'succeeded'],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Missing payment intent ID in successful authorized payment response');

    $this->stripe->captureAuthorizedPayment($order, []);
});

it('logs error when capture authorized payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    $this->httpClient->shouldReceive('request')->andThrow(new Exception('Error'));

    expect($this->stripe->captureAuthorizedPayment($order))->toBeNull();

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment capture failed: Error',
        'is_success' => 0,
    ]);
});

it('logs error when capture authorized payment response is invalid', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123/capture', [
        'id' => 'pi_123',
        'status' => 'invalid',
    ], 'post');

    $this->stripe->captureAuthorizedPayment($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment capture failed',
        'is_success' => 0,
    ]);
});

it('cancels authorized stripe payment successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123/cancel', [
        'id' => 'pi_123',
        'status' => 'canceled',
    ], 'post');

    $this->stripe->bindEvent('stripe.extendCancelFields', fn($data, $order): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->stripe->cancelAuthorizedPayment($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment canceled successfully',
        'is_success' => 1,
    ]);
});

it('throws exception when no successful authorized payment to cancel', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No successful authorized payment to cancel');

    $this->stripe->cancelAuthorizedPayment($order);
});

it('throws exception when missing payment intent id in cancel payment response', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => [],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Missing payment intent ID in successful authorized payment response');

    $this->stripe->cancelAuthorizedPayment($order);
});

it('logs error when canceling authorized payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    $this->httpClient->shouldReceive('request')->andThrow(new Exception('Error'));

    $this->stripe->cancelAuthorizedPayment($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment canceled failed: Error',
        'is_success' => 0,
    ]);
});

it('logs error when canceling authorized payment response is invalid', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'response' => ['id' => 'pi_123'],
    ]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123/cancel', [
        'id' => 'pi_123',
        'status' => 'invalid',
    ], 'post');

    $this->stripe->cancelAuthorizedPayment($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Canceling payment failed',
        'is_success' => 0,
    ]);
});

it('returns stripe payment intent if status is requires_capture or succeeded', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create())
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->stripe->putSession('ti_payregister_stripe_intent', 'pi_123');
    setupStripeRequest($this->httpClient, 'payment_intents/pi_123', [
        'id' => 'pi_123',
        'status' => 'succeeded',
    ]);

    expect($this->stripe->updatePaymentIntentSession($order)->status)->toBe('succeeded');
});

it('deletes existing payment profile', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $customer = Customer::factory()->create();
    $profile = PaymentProfile::factory()->create([
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card_123', 'customer_id' => 'cus_123'],
    ]);
    setupStripeRequest($this->httpClient, 'customers/cus_123', [
        'id' => 'cus_123',
    ], 'delete');

    $this->stripe->deletePaymentProfile($customer, $profile);

    $this->assertDatabaseHas('payment_profiles', ['payment_profile_id' => $profile->payment_profile_id]);
});

it('throws exception when customer payment profile not found', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Payment profile not found or customer not logged in');

    $this->stripe->payFromPaymentProfile($order);
});

it('creates payment successfully from stripe payment profile', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card_123', 'customer_id' => 'cus_123'],
    ]);
    setupStripeRequest($this->httpClient, 'customers/cus_123', [
        'id' => 'cus_123',
        'deleted' => true,
    ]);
    setupStripeRequest($this->httpClient, 'customers', [
        'id' => 'cus_123',
    ], 'post');
    setupStripeRequest($this->httpClient, 'payment_intents', [
        'id' => 'pi_123',
        'status' => 'succeeded',
    ], 'post');

    $this->stripe->payFromPaymentProfile($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('logs payment attempt and throws exception when payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card_123', 'customer_id' => 'cus_123'],
    ]);
    setupStripeRequest($this->httpClient, 'customers/cus_123', [
        'id' => 'cus_123',
        'deleted' => true,
    ]);
    setupStripeRequest($this->httpClient, 'customers', [
        'id' => 'cus_123',
    ], 'post');
    setupStripeRequest($this->httpClient, 'payment_intents', [
        'id' => 'pi_123',
        'status' => 'invalid',
    ], 'post');

    //    $stripe = Mockery::mock(Stripe::class)->makePartial()->shouldAllowMockingProtectedMethods();
    //    $gateway = Mockery::mock(StripeClient::class);
    //    $paymentIntents = Mockery::mock(PaymentIntentService::class);
    //    $gateway->paymentIntents = $paymentIntents;
    //
    //    $this->order->customer = Mockery::mock(Customer::class)->makePartial();
    //    $this->order->customer_name = 'John Doe';
    //    $stripe->shouldReceive('getHostObject')->andReturn($this->payment);
    //    $stripe->shouldReceive('paymentProfileExists')->andReturnTrue();
    //    $stripe->shouldReceive('createGateway')->andReturn($gateway);
    //    $stripe->shouldReceive('getPaymentFormFields')->with($this->order)->andReturn(['amount' => 1000])->once();
    //    $paymentIntents->shouldReceive('create')->andThrow(new Exception('Payment error'));
    //    $this->order->shouldReceive('logPaymentAttempt')->with('Payment error: Payment error', 0, Mockery::any(), Mockery::any())->once();

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later');

    $this->stripe->payFromPaymentProfile($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error: Status invalid',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('throw exception when fails to create stripe customer request fails ', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card_123', 'customer_id' => 'cus_123'],
    ]);
    $this->httpClient->shouldReceive('request')
        ->with('get', 'https://api.stripe.com/v1/customers/cus_123', Mockery::any(), Mockery::any(), false)
        ->andThrow(new Exception('Error'));

    $this->httpClient->shouldReceive('request')
        ->with('post', 'https://api.stripe.com/v1/customers', Mockery::any(), Mockery::any(), false)
        ->andThrow(new Exception('Creating customer failed'));

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->stripe->payFromPaymentProfile($order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error: Creating customer failed',
        'is_success' => 0,
    ]);
});

it('processes refund form and logs refund attempt', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'is_refundable' => 1,
        'response' => ['id' => 'pi_123', 'status' => 'succeeded', 'object' => 'payment_intent'],
    ]);
    setupStripeRequest($this->httpClient, 'refunds', [
        'id' => 're_123',
        'status' => 'succeeded',
    ], 'post');

    $this->stripe->bindEvent('stripe.extendRefundFields', fn($data, $order): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->stripe->processRefundForm([
        'refund_type' => 'full',
    ], $order, $paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment intent pi_123 refunded successfully -> (full: re_123)',
        'is_success' => 1,
    ]);

});

it('throws exception when stripe charge is already refunded', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'is_refundable' => 1,
        'refunded_at' => now(),
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Nothing to refund, payment has already been refunded');

    $this->stripe->processRefundForm([], $order, $paymentLog);
});

it('throws exception when no stripe charge to refund', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'is_refundable' => 1,
        'response' => ['status' => 'invalid'],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No charge to refund');

    $this->stripe->processRefundForm([], $order, $paymentLog);
});

it('throws exception when refund response fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'is_success' => 1,
        'is_refundable' => 1,
        'response' => ['id' => 'pi_123', 'status' => 'succeeded', 'object' => 'payment_intent'],
    ]);
    setupStripeRequest($this->httpClient, 'refunds', [
        'id' => 're_123',
        'status' => 'failed',
    ], 'post');

    $this->stripe->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Refund failed -> Refund failed',
        'is_success' => 0,
    ]);
});

it('redirects to stripe checkout when offsite mode is enabled', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $this->payment->offsite_enabled = true;
    $this->payment->transaction_type = 'auth_only';
    $customer = Customer::factory()->create();
    $order = Order::factory()
        ->for($customer, 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['customer_id' => 'cus_existing123'],
    ]);
    setupStripeRequest($this->httpClient, 'customers/cus_existing123', [
        'id' => 'cus_existing123',
    ]);
    setupStripeRequest($this->httpClient, 'checkout/sessions', [
        'id' => 'cs_123',
        'url' => 'https://checkout.stripe.com/pay/cs_123',
    ], 'post');

    $result = $this->stripe->processPaymentForm([
        'email' => 'test@example.com',
        'successPage' => 'checkout.success',
        'cancelPage' => 'checkout.checkout',
    ], $this->payment, $order);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toBe('https://checkout.stripe.com/pay/cs_123');
});

it('creates new customer for checkout session when profile has no customer_id', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $this->payment->offsite_enabled = true;
    $customer = Customer::factory()->create();
    $order = Order::factory()
        ->for($customer, 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'customers', [
        'id' => 'cus_new123',
    ], 'post');
    setupStripeRequest($this->httpClient, 'checkout/sessions', [
        'id' => 'cs_123',
        'url' => 'https://checkout.stripe.com/pay/cs_123',
    ], 'post');

    $result = $this->stripe->processPaymentForm([], $this->payment, $order);

    expect($result)->toBeInstanceOf(RedirectResponse::class);
});

it('does not include customer data in checkout session when order has no customer', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $this->payment->offsite_enabled = true;
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'checkout/sessions', [
        'id' => 'cs_123',
        'url' => 'https://checkout.stripe.com/pay/cs_123',
    ], 'post');

    $result = $this->stripe->processPaymentForm([], $this->payment, $order);

    expect($result)->toBeInstanceOf(RedirectResponse::class);
});

it('processes return url successfully when order is not yet processed', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->payment->applyGatewayClass();
    $this->payment->save();

    $request = Request::create('/ti_payregister/stripe_return_url/handle/'.$order->hash, 'GET', [
        'redirect' => 'checkout.success',
        'cancel' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $result = $this->stripe->processReturnUrl([$order->hash]);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toContain('checkout/success');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
    ]);
});

it('processes return url and skips logging when order is already processed', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100, 'processed' => 1]);
    $order->updateOrderStatus(1);
    $this->payment->applyGatewayClass();
    $this->payment->save();

    $request = Request::create('/ti_payregister/stripe_return_url/handle/'.$order->hash, 'GET', [
        'redirect' => 'checkout.success',
        'cancel' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $result = $this->stripe->processReturnUrl([$order->hash]);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toContain('checkout/success');
});

it('redirects to cancel page when order is not found in processReturnUrl', function(): void {
    $this->payment->applyGatewayClass();
    $this->payment->save();

    $request = Request::create('/ti_payregister/stripe_return_url/handle/invalid_hash', 'GET', [
        'redirect' => 'checkout.success',
        'cancel' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $result = $this->stripe->processReturnUrl(['invalid_hash']);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toContain('/checkout');
});

it('redirects to cancel page when payment method is invalid in processReturnUrl', function(): void {
    $otherPayment = Payment::factory()->create(['class_name' => Cod::class]);
    $order = Order::factory()
        ->for($otherPayment, 'payment_method')
        ->create(['order_total' => 100]);
    $otherPayment->applyGatewayClass();

    $request = Request::create('/ti_payregister/stripe_return_url/handle/'.$order->hash, 'GET', [
        'redirect' => 'checkout.success',
        'cancel' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $result = (new Stripe($otherPayment))->processReturnUrl([$order->hash]);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toContain('/checkout');
});

it('processes cancel url and logs cancellation', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $this->payment->applyGatewayClass();
    $this->payment->save();

    $request = Request::create('/ti_payregister/stripe_cancel_url/handle/'.$order->hash, 'GET', [
        'redirect' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $result = $this->stripe->processCancelUrl([$order->hash]);

    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and($result->getTargetUrl())->toContain('/checkout');

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment canceled by customer',
        'is_success' => 0,
    ]);
});

it('throws exception when order not found in processCancelUrl', function(): void {
    $this->payment->applyGatewayClass();
    $this->payment->save();

    $request = Request::create('/ti_payregister/stripe_cancel_url/handle/invalid_hash', 'GET', [
        'redirect' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No order found');

    $this->stripe->processCancelUrl(['invalid_hash']);
});

it('throws exception when payment method is invalid in processCancelUrl', function(): void {
    $otherPayment = Payment::factory()->create(['class_name' => Cod::class]);
    $order = Order::factory()
        ->for($otherPayment, 'payment_method')
        ->create(['order_total' => 100]);
    $otherPayment->applyGatewayClass();

    $request = Request::create('/ti_payregister/stripe_cancel_url/handle/'.$order->hash, 'GET', [
        'redirect' => 'checkout.checkout',
    ]);
    app()->instance('request', $request);

    expect(fn(): RedirectResponse => (new Stripe($otherPayment))->processCancelUrl([$order->hash]))
        ->toThrow(ApplicationException::class, 'No valid payment method found');
});

it('fires event to extend checkout session fields', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $this->payment->offsite_enabled = true;
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $this->stripe->bindEvent('stripe.extendCheckoutSessionFields', function(array &$fields, $order, $data): void {
        $fields['custom_field'] = 'custom_value';
    });

    setupStripeRequest($this->httpClient, 'checkout/sessions', [
        'id' => 'cs_123',
        'url' => 'https://checkout.stripe.com/pay/cs_123',
    ], 'post');

    $result = $this->stripe->processPaymentForm([], $this->payment, $order);

    expect($result)->toBeInstanceOf(RedirectResponse::class);
});

it('returns 400 when request method is not POST', function(): void {
    $response = $this->stripe->processWebhookUrl();

    expect($response->getStatusCode())->toBe(400)
        ->and($response->getContent())->toContain('Request method must be POST');
});

it('returns 400 when webhook secret is invalid', function(): void {
    $this->payment->applyGatewayClass();
    $this->payment->test_webhook_secret = 'whsec_test_webhook_secret';
    $request = Request::create('stripe_webhook', 'POST');
    app()->instance('request', $request);

    $response = $this->stripe->processWebhookUrl();

    expect($response->getStatusCode())->toBe(400)
        ->and($response->getContent())->toContain('Failed to parse webhook payload: ');
});

it('returns 400 if webhook payload is missing event type', function(): void {
    $this->payment->applyGatewayClass();
    $this->payment->test_webhook_secret = 'whsec_test_webhook_secret';
    $webhookSecret = 'whsec_test_webhook_secret';
    $this->payment->save();

    $payload = [
        'id' => 'evt_test_webhook',
        'type' => '',
    ];

    $timestamp = time();
    $payloadJson = json_encode($payload);
    $signature = hash_hmac('sha256', sprintf('%d.%s', $timestamp, $payloadJson), $webhookSecret);

    $response = $this->postJson('/ti_payregister/stripe_webhook/handle', $payload, [
        'Stripe-Signature' => sprintf('t=%d,v1=%s', $timestamp, $signature),
    ]);

    expect($response->getStatusCode())->toBe(400)
        ->and($response->getContent())->toContain('Missing webhook event name');
});

it('rejects webhook event when webhook secret is not configured', function(): void {
    Queue::fake();
    Event::fake(['payregister.stripe.webhook.handle']);
    $order = Order::factory()->for($this->payment, 'payment_method')->create();
    $this->payment->applyGatewayClass();
    $this->payment->save();
    $payload = [
        'id' => 'evt_test_webhook',
        'type' => 'payment_intent.succeeded',
        'data' => [
            'object' => [
                'status' => 'succeeded',
                'metadata' => [
                    'order_id' => $order->getKey(),
                ],
            ],
        ],
    ];

    $response = $this->postJson('/ti_payregister/stripe_webhook/handle', $payload);

    expect($response->getStatusCode())->toBe(400)
        ->and($response->getContent())->toContain('Webhook secret is not configured');

    Event::assertNotDispatched('payregister.stripe.webhook.handle');
    Queue::assertNotPushed(ProcessStripeWebhookJob::class);
});

it('handles webhook event with webhook secret', function(): void {
    Queue::fake();
    Event::fake(['payregister.stripe.webhook.handle']);
    $order = Order::factory()->for($this->payment, 'payment_method')->create();
    $this->payment->applyGatewayClass();
    $this->payment->test_webhook_secret = 'whsec_test_webhook_secret';
    $webhookSecret = 'whsec_test_webhook_secret';
    $this->payment->save();
    $payload = [
        'id' => 'evt_test_webhook',
        'type' => 'payment_intent.succeeded',
        'data' => [
            'object' => [
                'status' => 'requires_capture',
                'metadata' => [
                    'order_id' => $order->getKey(),
                ],
            ],
        ],
    ];
    $timestamp = time();
    $payloadJson = json_encode($payload);
    $signature = hash_hmac('sha256', sprintf('%d.%s', $timestamp, $payloadJson), $webhookSecret);

    $response = $this->postJson('/ti_payregister/stripe_webhook/handle', $payload, [
        'Stripe-Signature' => sprintf('t=%d,v1=%s', $timestamp, $signature),
    ]);

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getContent())->toContain('Webhook Handled');

    Event::assertDispatched('payregister.stripe.webhook.handle');
    Queue::assertPushed(ProcessStripeWebhookJob::class);
});

it('returns null when verifying payment intent fails due to stripe api error', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $this->httpClient->shouldReceive('request')->andThrow(new Exception('Stripe API error'));

    expect($this->stripe->verifyPaymentIntentForOrder($order, 'pi_test_123'))->toBeNull();
});

it('returns null when verifying payment intent with mismatched order metadata', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_test_123', [
        'id' => 'pi_test_123',
        'object' => 'payment_intent',
        'status' => 'succeeded',
        'amount' => 10000,
        'metadata' => ['order_id' => '99999'],
    ]);

    expect($this->stripe->verifyPaymentIntentForOrder($order, 'pi_test_123'))->toBeNull();
});

it('returns null when verifying payment intent with invalid status', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_test_123', [
        'id' => 'pi_test_123',
        'object' => 'payment_intent',
        'status' => 'processing',
        'amount' => 10000,
        'metadata' => ['order_id' => (string)$order->order_id],
    ]);

    expect($this->stripe->verifyPaymentIntentForOrder($order, 'pi_test_123'))->toBeNull();
});

it('returns null when verifying payment intent with mismatched amount', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'payment_intents/pi_test_123', [
        'id' => 'pi_test_123',
        'object' => 'payment_intent',
        'status' => 'succeeded',
        'amount' => 9999,
        'metadata' => ['order_id' => (string)$order->order_id],
    ]);

    expect($this->stripe->verifyPaymentIntentForOrder($order, 'pi_test_123'))->toBeNull();
});

it('returns null when verifying checkout session fails due to stripe api error', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $this->httpClient->shouldReceive('request')->andThrow(new Exception('Stripe API error'));

    expect($this->stripe->verifyCheckoutSessionForOrder($order, 'cs_test_123'))->toBeNull();
});

it('returns null when verifying checkout session with mismatched order metadata', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'checkout/sessions/cs_test_123', [
        'id' => 'cs_test_123',
        'object' => 'checkout.session',
        'status' => 'complete',
        'amount_total' => 10000,
        'metadata' => ['order_id' => '99999'],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => 'succeeded',
            'amount' => 10000,
            'metadata' => ['order_id' => '99999'],
        ],
    ]);

    expect($this->stripe->verifyCheckoutSessionForOrder($order, 'cs_test_123'))->toBeNull();
});

it('returns null when verifying checkout session that is not complete', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'checkout/sessions/cs_test_123', [
        'id' => 'cs_test_123',
        'object' => 'checkout.session',
        'status' => 'open',
        'amount_total' => 10000,
        'metadata' => ['order_id' => (string)$order->order_id],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => 'succeeded',
            'amount' => 10000,
            'metadata' => ['order_id' => (string)$order->order_id],
        ],
    ]);

    expect($this->stripe->verifyCheckoutSessionForOrder($order, 'cs_test_123'))->toBeNull();
});

it('returns null when verifying checkout session with invalid payment intent status', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'checkout/sessions/cs_test_123', [
        'id' => 'cs_test_123',
        'object' => 'checkout.session',
        'status' => 'complete',
        'amount_total' => 10000,
        'metadata' => ['order_id' => (string)$order->order_id],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => 'processing',
            'amount' => 10000,
            'metadata' => ['order_id' => (string)$order->order_id],
        ],
    ]);

    expect($this->stripe->verifyCheckoutSessionForOrder($order, 'cs_test_123'))->toBeNull();
});

it('returns null when verifying checkout session with mismatched payment intent amount', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_secret_key = 'test_secret_key';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    setupStripeRequest($this->httpClient, 'checkout/sessions/cs_test_123', [
        'id' => 'cs_test_123',
        'object' => 'checkout.session',
        'status' => 'complete',
        'amount_total' => 10000,
        'metadata' => ['order_id' => (string)$order->order_id],
        'payment_intent' => [
            'id' => 'pi_from_session',
            'object' => 'payment_intent',
            'status' => 'succeeded',
            'amount' => 9999,
            'metadata' => ['order_id' => (string)$order->order_id],
        ],
    ]);

    expect($this->stripe->verifyCheckoutSessionForOrder($order, 'cs_test_123'))->toBeNull();
});
