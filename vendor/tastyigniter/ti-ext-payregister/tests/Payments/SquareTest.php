<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Payments\Square;
use Igniter\User\Models\Customer;
use Mockery;
use Square\Apis\CardsApi;
use Square\Apis\CustomersApi;
use Square\Apis\PaymentsApi;
use Square\Apis\RefundsApi;
use Square\Http\ApiResponse;
use Square\Models\Card;
use Square\Models\Error;
use Square\SquareClient;
use Square\SquareClientBuilder;

beforeEach(function(): void {
    $this->payment = Payment::factory()->create([
        'class_name' => Square::class,
    ]);
    $this->square = new Square($this->payment);
});

function setupSquareClient(): SquareClient
{
    $clientBuilder = mock(SquareClientBuilder::class)->makePartial();
    app()->instance(SquareClientBuilder::class, $clientBuilder);
    $client = Mockery::mock(SquareClient::class);
    $clientBuilder->shouldReceive('build')->andReturn($client);

    return $client;
}

function setupSuccessfulPayment(SquareClient $client): void
{
    $response = Mockery::mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(true);
    $response->shouldReceive('getResult')->andReturn(['payment' => 'success']);
    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $paymentsApi->shouldReceive('createPayment')->andReturn($response);
}

it('returns correct payment form view for square', function(): void {
    expect(Square::$paymentFormView)->toBe('igniter.payregister::_partials.square.payment_form');
});

it('returns correct fields config for square', function(): void {
    expect($this->square->defineFieldsConfig())->toBe('igniter.payregister::/models/square');
});

it('returns hidden fields for square', function(): void {
    $hiddenFields = $this->square->getHiddenFields();
    expect($hiddenFields)->toBe([
        'square_card_nonce' => '',
        'square_card_token' => '',
    ]);
});

it('returns true if in test mode for square', function(): void {
    $this->payment->transaction_mode = 'test';
    expect($this->square->isTestMode())->toBeTrue();
});

it('returns false if not in test mode for square', function(): void {
    $this->payment->transaction_mode = 'live';
    expect($this->square->isTestMode())->toBeFalse();
});

it('returns test app id in test mode for square', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_app_id = 'test_app_id';
    expect($this->square->getAppId())->toBe('test_app_id');
});

it('returns live app id in live mode for square', function(): void {
    $this->payment->transaction_mode = 'live';
    $this->payment->live_app_id = 'live_app_id';
    expect($this->square->getAppId())->toBe('live_app_id');
});

it('returns test access token in test mode for square', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    expect($this->square->getAccessToken())->toBe('test_access_token');
});

it('returns live access token in live mode for square', function(): void {
    $this->payment->transaction_mode = 'live';
    $this->payment->live_access_token = 'live_access_token';
    expect($this->square->getAccessToken())->toBe('live_access_token');
});

it('returns test location id in test mode for square', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_location_id = 'test_location_id';
    expect($this->square->getLocationId())->toBe('test_location_id');
});

it('returns live location id in live mode for square', function(): void {
    $this->payment->transaction_mode = 'live';
    $this->payment->live_location_id = 'live_location_id';
    expect($this->square->getLocationId())->toBe('live_location_id');
});

it('adds correct js files in test mode for square', function(): void {
    $this->payment->transaction_mode = 'test';

    $controller = Mockery::mock(MainController::class);
    $controller->shouldReceive('addJs')->with('https://sandbox.web.squarecdn.com/v1/square.js', 'square-js')->once();
    $controller->shouldReceive('addJs')->with('igniter.payregister::/js/process.square.js', 'process-square-js')->once();

    $this->square->beforeRenderPaymentForm($this->square, $controller);
});

it('adds correct js files in live mode for square', function(): void {
    $this->payment->transaction_mode = 'live';

    $controller = Mockery::mock(MainController::class);
    $controller->shouldReceive('addJs')->with('https://web.squarecdn.com/v1/square.js', 'square-js')->once();
    $controller->shouldReceive('addJs')->with('igniter.payregister::/js/process.square.js', 'process-square-js')->once();

    $this->square->beforeRenderPaymentForm($this->square, $controller);
});

it('returns true for completesPaymentOnClient for square', function(): void {
    expect($this->square->completesPaymentOnClient())->toBeTrue();
});

it('processes square payment form and returns success', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $order->totals()->create(['code' => 'tip', 'title' => 'Tip', 'value' => 100]);

    $client = setupSquareClient();
    setupSuccessfulPayment($client);

    $this->square->processPaymentForm([
        'square_card_nonce' => 'nonce',
        'square_card_token' => 'token',
    ], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('processes square payment form with new payment profile and returns success', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    $client = setupSquareClient();

    $customersApi = Mockery::mock(CustomersApi::class);
    $client->shouldReceive('getCustomersApi')->andReturn($customersApi);
    $createCustomerResponse = mock(ApiResponse::class);
    $customersApi->shouldReceive('createCustomer')->andReturn($createCustomerResponse);
    $createCustomerResponse->shouldReceive('isSuccess')->andReturn(true);
    $createCustomerResponse->shouldReceive('getResult')->andReturnSelf();
    $customerObject = mock(\Square\Models\Customer::class)->makePartial();
    $customerObject->shouldReceive('getId')->andReturn('cust123');
    $customerObject->shouldReceive('getReferenceId')->andReturn('ref123');
    $createCustomerResponse->shouldReceive('getCustomer')->andReturn($customerObject);

    $cardsApi = Mockery::mock(CardsApi::class);
    $client->shouldReceive('getCardsApi')->andReturn($cardsApi);
    $createCardResponse = mock(ApiResponse::class);
    $cardsApi->shouldReceive('createCard')->andReturn($createCardResponse);
    $createCardResponse->shouldReceive('isSuccess')->andReturn(true);
    $createCardResponse->shouldReceive('getResult')->andReturnSelf();
    $cardObject = mock(Card::class)->makePartial();
    $cardObject->shouldReceive('getId')->andReturn('card123');
    $createCardResponse->shouldReceive('getCard')->andReturn($cardObject);

    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $response = mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(true);
    $response->shouldReceive('getResult')->andReturn(['payment' => 'success']);
    $paymentsApi->shouldReceive('createPayment')->andReturn($response);

    $this->square->processPaymentForm([
        'create_payment_profile' => 1,
        'square_card_nonce' => 'nonce',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('processes square payment form with existing payment profile and returns success', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card123', 'customer_id' => 'cust123'],
    ]);
    $client = setupSquareClient();

    $customersApi = Mockery::mock(CustomersApi::class);
    $client->shouldReceive('getCustomersApi')->andReturn($customersApi);
    $retrieveCustomerResponse = mock(ApiResponse::class);
    $retrieveCustomerResponse->shouldReceive('isSuccess')->andReturn(true);
    $customersApi->shouldReceive('retrieveCustomer')->andReturn($retrieveCustomerResponse);
    $retrieveCustomerResponse->shouldReceive('getResult')->andReturnSelf();
    $customerObject = mock(\Square\Models\Customer::class)->makePartial();
    $customerObject->shouldReceive('getId')->andReturn('cust123');
    $customerObject->shouldReceive('getReferenceId')->andReturn('ref123');
    $retrieveCustomerResponse->shouldReceive('getCustomer')->andReturn($customerObject);

    $cardsApi = Mockery::mock(CardsApi::class);
    $client->shouldReceive('getCardsApi')->andReturn($cardsApi);
    $retrieveCardResponse = mock(ApiResponse::class);
    $cardsApi->shouldReceive('retrieveCard')->andReturn($retrieveCardResponse);
    $retrieveCardResponse->shouldReceive('isSuccess')->andReturn(true);
    $retrieveCardResponse->shouldReceive('getResult')->andReturnSelf();
    $cardObject = mock(Card::class)->makePartial();
    $cardObject->shouldReceive('getId')->andReturn('card123');
    $retrieveCardResponse->shouldReceive('getCard')->andReturn($cardObject);

    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $response = mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(true);
    $response->shouldReceive('getResult')->andReturn(['payment' => 'success']);
    $paymentsApi->shouldReceive('createPayment')->andReturn($response);

    $this->square->processPaymentForm([
        'create_payment_profile' => 1,
        'square_card_nonce' => 'nonce',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('throws exception if payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $client = setupSquareClient();
    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $paymentsApi->shouldReceive('createPayment')->andThrow(new Exception('Payment error'));

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later');

    $this->square->processPaymentForm(['square_card_nonce' => 'nonce'], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
        'is_success' => 0,
    ]);
});

it('throws exception if payment response fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $errorMock = Mockery::mock(Error::class);
    $errorMock->shouldReceive('getDetail')->andReturn('Payment error');
    $response = Mockery::mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(false);
    $response->shouldReceive('getErrors')->andReturn([$errorMock]);
    $response->shouldReceive('getResult')->andReturn([]);

    $client = setupSquareClient();
    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $paymentsApi->shouldReceive('createPayment')->andReturn($response);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later');

    $this->square->processPaymentForm(['square_card_nonce' => 'nonce'], $this->payment, $order);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
        'is_success' => 0,
    ]);
});

it('throws exception when createOrFetchCustomer fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['customer_id' => 'cust123', 'card_id' => 'card123'],
    ]);
    $client = setupSquareClient();
    $customersApi = Mockery::mock(CustomersApi::class);
    $client->shouldReceive('getCustomersApi')->andReturn($customersApi);
    $retrieveCustomerResponse = mock(ApiResponse::class);
    $customersApi->shouldReceive('retrieveCustomer')->andReturn($retrieveCustomerResponse);
    $retrieveCustomerResponse->shouldReceive('isSuccess')->andReturn(false);
    $createCustomerResponse = mock(ApiResponse::class);
    $customersApi->shouldReceive('createCustomer')->andReturn($createCustomerResponse);
    $createCustomerResponse->shouldReceive('isSuccess')->andReturn(false);
    $errorMock = Mockery::mock(Error::class);
    $errorMock->shouldReceive('getDetail')->andReturn('Customer creation failed');
    $createCustomerResponse->shouldReceive('getErrors')->andReturn([$errorMock]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Square Customer Create Error: Customer creation failed');

    $this->square->processPaymentForm([
        'create_payment_profile' => 1,
        'square_card_nonce' => 'nonce',
    ], $this->payment, $order);
});

it('throws exception when createOrFetchCard fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['customer_id' => 'cust123', 'card_id' => 'card123'],
    ]);
    $client = setupSquareClient();
    $customersApi = Mockery::mock(CustomersApi::class);
    $client->shouldReceive('getCustomersApi')->andReturn($customersApi);
    $retrieveCustomerResponse = mock(ApiResponse::class);
    $customersApi->shouldReceive('retrieveCustomer')->andReturn($retrieveCustomerResponse);
    $retrieveCustomerResponse->shouldReceive('isSuccess')->andReturn(true);
    $retrieveCustomerResponse->shouldReceive('getResult')->andReturnSelf();
    $customerObject = mock(\Square\Models\Customer::class)->makePartial();
    $customerObject->shouldReceive('getId')->andReturn('cust123');
    $customerObject->shouldReceive('getReferenceId')->andReturn('ref123');
    $retrieveCustomerResponse->shouldReceive('getCustomer')->andReturn($customerObject);

    $cardsApi = Mockery::mock(CardsApi::class);
    $client->shouldReceive('getCardsApi')->andReturn($cardsApi);
    $retrieveCardResponse = mock(ApiResponse::class);
    $cardsApi->shouldReceive('retrieveCard')->andReturn($retrieveCardResponse);
    $retrieveCardResponse->shouldReceive('isSuccess')->andReturn(false);
    $createCardResponse = mock(ApiResponse::class);
    $cardsApi->shouldReceive('createCard')->andReturn($createCardResponse);
    $createCardResponse->shouldReceive('isSuccess')->andReturn(false);
    $errorMock = Mockery::mock(Error::class);
    $errorMock->shouldReceive('getDetail')->andReturn('Card creation failed');
    $createCardResponse->shouldReceive('getErrors')->andReturn([$errorMock]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Square Create Payment Card Error: Card creation failed');

    $this->square->processPaymentForm([
        'create_payment_profile' => 1,
        'square_card_nonce' => 'nonce',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ], $this->payment, $order);
});

it('returns true when payment profiles are supported', function(): void {
    $result = $this->square->supportsPaymentProfiles();

    expect($result)->toBeTrue();
});

it('processes square refund form and logs refund attempt', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['payment' => ['status' => 'COMPLETED', 'id' => 'payment_id']],
    ]);

    $client = setupSquareClient();
    $response = Mockery::mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(true);
    $response->shouldReceive('getResult')->andReturn(['id' => 'refund_id']);
    $refundsApi = Mockery::mock(RefundsApi::class);
    $refundsApi->shouldReceive('refundPayment')->andReturn($response)->once();
    $client->shouldReceive('getRefundsApi')->andReturn($refundsApi);

    $this->square->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);
});

it('throws exception when charge is already refunded', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['payment' => ['status' => 'not_completed']],
        'refunded_at' => now(),
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Nothing to refund, payment already refunded');

    $this->square->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);
});

it('throws exception when no square charge to refund', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['payment' => ['status' => 'not_completed']],
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No charge to refund');

    $this->square->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);
});

it('throws exception when refund response fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()->for($this->payment, 'payment_method')->create(['order_total' => 100]);
    $paymentLog = PaymentLog::factory()->create([
        'order_id' => $order->order_id,
        'response' => ['payment' => ['status' => 'COMPLETED', 'id' => 'payment_id']],
    ]);

    $client = setupSquareClient();
    $response = Mockery::mock(ApiResponse::class);
    $response->shouldReceive('isSuccess')->andReturn(false);
    $response->shouldReceive('getResult')->andReturn(['id' => 'refund_id']);
    $refundsApi = Mockery::mock(RefundsApi::class);
    $refundsApi->shouldReceive('refundPayment')->andReturn($response)->once();
    $client->shouldReceive('getRefundsApi')->andReturn($refundsApi);

    $this->square->bindEvent('square.extendRefundFields', fn($fields, $order, $data): array => [
        'extra_field' => 'extra_value',
    ]);

    $this->square->processRefundForm(['refund_type' => 'full'], $order, $paymentLog);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Refund failed -> Refund failed',
        'is_success' => 0,
    ]);
});

it('creates payment successfully from square payment profile', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card123', 'customer_id' => 'cust123'],
    ]);

    $client = setupSquareClient();
    setupSuccessfulPayment($client);

    $this->square->payFromPaymentProfile($order, []);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment successful',
        'is_success' => 1,
        'is_refundable' => 1,
    ]);
});

it('throws exception when no square payment profile is found', function(): void {
    $order = Order::factory()
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Payment profile not found');

    $this->square->payFromPaymentProfile($order, []);
});

it('throws exception when payment request fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $order = Order::factory()
        ->for(Customer::factory()->create(), 'customer')
        ->for($this->payment, 'payment_method')
        ->create(['order_total' => 100]);
    PaymentProfile::factory()->create([
        'customer_id' => $order->customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['card_id' => 'card123', 'customer_id' => 'cust123'],
    ]);

    $client = setupSquareClient();
    $paymentsApi = Mockery::mock(PaymentsApi::class);
    $client->shouldReceive('getPaymentsApi')->andReturn($paymentsApi);
    $paymentsApi->shouldReceive('createPayment')->andThrow(new Exception('Payment error'));

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later');

    $this->square->payFromPaymentProfile($order, []);

    $this->assertDatabaseHas('payment_logs', [
        'order_id' => $order->order_id,
        'message' => 'Payment error -> Payment error',
        'is_success' => 0,
    ]);
});

it('deletes payment profile successfully', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $customer = Customer::factory()->create();
    $profile = PaymentProfile::factory()->create([
        'customer_id' => $customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['customer_id' => 'cust123', 'card_id' => 'card123'],
    ]);
    $client = setupSquareClient();
    $cardsApi = Mockery::mock(CardsApi::class);
    $client->shouldReceive('getCardsApi')->andReturn($cardsApi);
    $response = mock(ApiResponse::class);
    $cardsApi->shouldReceive('disableCard')->andReturn($response);
    $response->shouldReceive('isSuccess')->andReturn(true);

    $result = $this->square->deletePaymentProfile($customer, $profile);

    expect($result)->toBeNull();
});

it('throws exception when deleting payment profile fails', function(): void {
    $this->payment->transaction_mode = 'test';
    $this->payment->test_access_token = 'test_access_token';
    $customer = Customer::factory()->create();
    $profile = PaymentProfile::factory()->create([
        'customer_id' => $customer->getKey(),
        'payment_id' => $this->payment->getKey(),
        'profile_data' => ['customer_id' => 'cust123', 'card_id' => 'card123'],
    ]);
    $client = setupSquareClient();
    $cardsApi = Mockery::mock(CardsApi::class);
    $client->shouldReceive('getCardsApi')->andReturn($cardsApi);
    $cardsApi->shouldReceive('disableCard')->andReturn($response = mock(ApiResponse::class));
    $response->shouldReceive('isSuccess')->andReturn(false);
    $errorMock = Mockery::mock(Error::class);
    $errorMock->shouldReceive('getDetail')->andReturn('Deleting card failed');
    $response->shouldReceive('getErrors')->andReturn([$errorMock]);

    expect(fn() => $this->square->deletePaymentProfile($customer, $profile))
        ->toThrow(ApplicationException::class, 'Square Delete Payment Card Error: Deleting card failed');
});
