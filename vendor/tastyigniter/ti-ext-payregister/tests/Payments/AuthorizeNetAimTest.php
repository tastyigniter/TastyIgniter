<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Classes\AuthorizeNetClient;
use Igniter\PayRegister\Classes\AuthorizeNetTransactionRequest;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Payments\AuthorizeNetAim;
use Illuminate\Support\Facades\Event;
use Mockery;
use net\authorize\api\contract\v1\TransactionResponseType;
use net\authorize\api\contract\v1\TransactionResponseType\MessagesAType\MessageAType;

beforeEach(function(): void {
    $this->payment = Payment::factory()->create([
        'class_name' => AuthorizeNetAim::class,
    ]);
    $this->authorizeNetAim = new AuthorizeNetAim($this->payment);
});

it('returns correct payment form view for authorizenet', function(): void {
    expect(AuthorizeNetAim::$paymentFormView)->toBe('igniter.payregister::_partials.authorizenetaim.payment_form');
});

it('returns correct fields config for authorizenet', function(): void {
    expect($this->authorizeNetAim->defineFieldsConfig())->toBe('igniter.payregister::/models/authorizenetaim');
});

it('returns hidden fields with default values', function(): void {
    $gateway = new AuthorizeNetAim;

    $hiddenFields = $gateway->getHiddenFields();

    expect($hiddenFields)->toBeArray()
        ->and($hiddenFields)->toHaveKey('authorizenetaim_DataValue', '')
        ->and($hiddenFields)->toHaveKey('authorizenetaim_DataDescriptor', '');
});

it('returns accepted cards with correct labels', function(): void {
    $gateway = new AuthorizeNetAim;

    $acceptedCards = $gateway->getAcceptedCards();

    expect($acceptedCards)->toBeArray()
        ->and($acceptedCards)->toHaveKey('visa', 'lang:igniter.payregister::default.authorize_net_aim.text_visa')
        ->and($acceptedCards)->toHaveKey('mastercard', 'lang:igniter.payregister::default.authorize_net_aim.text_mastercard')
        ->and($acceptedCards)->toHaveKey('american_express', 'lang:igniter.payregister::default.authorize_net_aim.text_american_express')
        ->and($acceptedCards)->toHaveKey('jcb', 'lang:igniter.payregister::default.authorize_net_aim.text_jcb')
        ->and($acceptedCards)->toHaveKey('diners_club', 'lang:igniter.payregister::default.authorize_net_aim.text_diners_club');
});

it('returns correct endpoint for authorizenet test mode', function(): void {
    $this->payment->transaction_mode = 'test';

    $result = $this->authorizeNetAim->getEndPoint();

    expect($result)->toBe('https://jstest.authorize.net');
});

it('returns correct endpoint for authorizenet live mode', function(): void {
    $this->payment->transaction_mode = 'live';

    $result = $this->authorizeNetAim->getEndPoint();

    expect($result)->toBe('https://js.authorize.net');
});

it('returns correct authorizenet model value', function($attribute, $methodName, $value, $returnValue): void {
    $this->payment->$attribute = $value;

    expect($this->authorizeNetAim->$methodName())->toBe($returnValue);
})->with([
    ['client_key', 'getClientKey', 'client123', 'client123'],
    ['transaction_key', 'getTransactionKey', 'key123', 'key123'],
    ['api_login_id', 'getApiLoginID', 'login123', 'login123'],
    ['transaction_mode', 'isTestMode', 'live', false],
    ['transaction_mode', 'isTestMode', 'test', true],
    ['transaction_type', 'shouldAuthorizePayment', 'auth_only', true],
    ['transaction_type', 'shouldAuthorizePayment', 'auth_capture', false],
]);

it('adds JavaScript file to the controller', function(): void {
    $controller = mock(MainController::class);

    $controller
        ->shouldReceive('addJs')
        ->with('igniter.payregister::/js/authorizenetaim.js', 'authorizenetaim-js')
        ->once();

    $this->authorizeNetAim->beforeRenderPaymentForm($this->authorizeNetAim, $controller);
});

it('processes authorizenet payment form and logs successful payment', function(): void {
    $this->payment->transaction_type = 'auth';
    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $request = mock(AuthorizeNetTransactionRequest::class);
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('1')->twice();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->twice();
    $response->shouldReceive('getTransId')->andReturn('12345')->once();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $order = mock(Order::class)->makePartial();
    $order->payment_method = $this->payment;
    $order->order_total = 100;
    $order->shouldReceive('logPaymentAttempt')->with('Payment successful', 1, Mockery::any(), Mockery::any(), true)->once();
    $order->shouldReceive('updateOrderStatus')->once();
    $order->shouldReceive('markAsPaymentProcessed')->once();
    $data = ['authorizenetaim_DataDescriptor' => 'descriptor', 'authorizenetaim_DataValue' => 'value'];

    $this->payment->applyGatewayClass();

    $this->authorizeNetAim->processPaymentForm($data, $this->payment, $order);
});

it('processes authorizenet payment form and logs authorized payment', function(): void {
    $this->payment->transaction_type = 'auth_only';
    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $request = mock(AuthorizeNetTransactionRequest::class);
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('1');
    $response->shouldReceive('getMessages')->andReturn([$messageAType]);
    $response->shouldReceive('getTransId')->andReturn('12345');
    $response->shouldReceive('getAccountNumber')->andReturn('****1111');
    $response->shouldReceive('getAccountType')->andReturn('Visa');
    $response->shouldReceive('getAuthCode')->andReturn('auth123');
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $order = mock(Order::class)->makePartial();
    $order->payment_method = $this->payment;
    $order->order_total = 100;
    $order->shouldReceive('logPaymentAttempt')->with('Payment authorized', 1, Mockery::any(), Mockery::any())->once();
    $order->shouldReceive('updateOrderStatus');
    $order->shouldReceive('markAsPaymentProcessed');

    $data = ['authorizenetaim_DataDescriptor' => 'descriptor', 'authorizenetaim_DataValue' => 'value'];

    $this->payment->applyGatewayClass();

    $this->authorizeNetAim->processPaymentForm($data, $this->payment, $order);
});

it('throws exception if authorizenet payment form processing fails', function(): void {
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andThrow(new Exception('Payment error'));
    app()->instance(AuthorizeNetClient::class, $authorizeClient);
    $order = mock(Order::class)->makePartial();
    $order->shouldReceive('logPaymentAttempt')->with('Payment error -> Payment error', 0, Mockery::any())->once();
    $order->payment_method = $this->payment;
    $order->order_total = 100;
    $data = ['authorizenetaim_DataDescriptor' => 'descriptor', 'authorizenetaim_DataValue' => 'value'];

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Sorry, there was an error processing your payment. Please try again later.');

    $this->payment->applyGatewayClass();

    $this->authorizeNetAim->processPaymentForm($data, $this->payment, $order);
});

it('processes authorizenet payment form and logs failed payment', function(): void {
    $messageAType = (new MessageAType)->setCode('2')->setDescription('Declined');
    $request = mock(AuthorizeNetTransactionRequest::class);
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('2')->twice();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->atMost(5);
    $response->shouldReceive('getTransId')->andReturn('12345')->once();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $order = mock(Order::class)->makePartial();
    $order->order_id = 123;
    $order->payment_method = $this->payment;
    $order->order_total = 100;
    $order->shouldReceive('logPaymentAttempt')->with('Payment unsuccessful -> Declined', 0, Mockery::any(), Mockery::any())->once();
    $order->shouldNotReceive('updateOrderStatus');
    $order->shouldNotReceive('markAsPaymentProcessed');

    $data = ['authorizenetaim_DataDescriptor' => 'descriptor', 'authorizenetaim_DataValue' => 'value'];

    $this->payment->applyGatewayClass();

    $this->authorizeNetAim->processPaymentForm($data, $this->payment, $order);
});

it('processes authorizenet full refund successfully', function(): void {
    $messageAType = (new MessageAType)->setCode('2')->setDescription('Declined');
    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->shouldReceive('markAsRefundProcessed')->once();
    $paymentLog->refunded_at = null;
    $paymentLog->response = ['status' => '1', 'id' => '12345', 'card_holder' => '****1111'];

    $order = mock(Order::class)->makePartial();
    $order->shouldReceive('logPaymentAttempt');

    $order->order_total = 100;

    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('1')->once();
    $response->shouldReceive('getTransId')->andReturn('54321')->once();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->twice();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $data = ['refund_type' => 'full'];

    $this->authorizeNetAim->processRefundForm($data, $order, $paymentLog);
});

it('authorizenet: throws exception if refund amount exceeds order total', function(): void {
    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->refunded_at = null;
    $paymentLog->response = ['status' => '1', 'id' => '12345', 'card_holder' => '****1111'];
    $order = mock(Order::class)->makePartial();
    $order->order_total = 100;

    $data = ['refund_type' => 'partial', 'refund_amount' => 150];

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Refund amount should be be less than or equal to the order total');

    $this->authorizeNetAim->processRefundForm($data, $order, $paymentLog);
});

it('authorizenet: throws exception when refund request fails', function(): void {
    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->refunded_at = null;
    $paymentLog->response = ['status' => '1', 'id' => '12345', 'card_holder' => '****1111'];
    $order = mock(Order::class)->makePartial();
    $order->order_total = 100;
    $order->shouldReceive('logPaymentAttempt')->with('Refund failed -> Refund request error', 0, Mockery::any(), [])->once();
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andThrow(new Exception('Refund request error'));
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $data = ['refund_type' => 'partial', 'refund_amount' => 100];

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Refund failed, please try again later or contact system administrator');

    $this->authorizeNetAim->processRefundForm($data, $order, $paymentLog);
});

it('authorizenet: captures authorized payment successfully', function(): void {
    Event::fake();
    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('1')->twice();
    $response->shouldReceive('getTransId')->andReturn('54321')->once();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->twice();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $request = mock(AuthorizeNetTransactionRequest::class);
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->response = ['id' => '12345'];

    $order = mock(Order::class)->makePartial();
    $order->hash = 'order_hash';
    $order->shouldReceive('logPaymentAttempt')->with('Payment successful', 1, [], Mockery::any(), true)->once();
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturn($paymentLog)
        ->once();

    $expectedResponse = $this->authorizeNetAim->captureAuthorizedPayment($order);

    Event::assertDispatched('payregister.authorizenetaim.extendCaptureRequest');

    expect($response)->toEqual($expectedResponse);
});

it('authorizenet: captures authorized payment failed', function(): void {
    Event::fake();
    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('2')->twice();
    $response->shouldReceive('getTransId')->andReturn('54321');
    $response->shouldReceive('getMessages')->andReturn([$messageAType]);
    $response->shouldReceive('getAccountNumber')->andReturn('****1111');
    $response->shouldReceive('getAccountType')->andReturn('Visa');
    $response->shouldReceive('getAuthCode')->andReturn('auth123');
    $request = mock(AuthorizeNetTransactionRequest::class);
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->response = ['id' => '12345'];

    $order = mock(Order::class)->makePartial();
    $order->hash = 'order_hash';
    $order->shouldReceive('logPaymentAttempt')->with('Payment failed', 0, [], Mockery::any())->once();
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturn($paymentLog)
        ->once();

    $expectedResponse = $this->authorizeNetAim->captureAuthorizedPayment($order);

    Event::assertDispatched('payregister.authorizenetaim.extendCaptureRequest');

    expect($response)->toEqual($expectedResponse);
});

it('authorizenet: throws exception if no successful transaction to capture', function(): void {
    $order = mock(Order::class)->makePartial();
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturnNull()
        ->once();

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No successful transaction to capture');

    $this->authorizeNetAim->captureAuthorizedPayment($order);
});

it('authorizenet: cancels authorized payment successfully', function(): void {
    Event::fake();
    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->is_success = true;
    $paymentLog->response = ['id' => '12345'];
    $order = mock(Order::class)->makePartial();
    $order->hash = 'order_hash';
    $order->shouldReceive('logPaymentAttempt');
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturn($paymentLog)
        ->once();

    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('1')->twice();
    $response->shouldReceive('getTransId')->andReturn('54321')->once();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->twice();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $request = mock(AuthorizeNetTransactionRequest::class);
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $expectedResponse = $this->authorizeNetAim->cancelAuthorizedPayment($order);

    expect($response)->toEqual($expectedResponse);
    Event::assertDispatched('payregister.authorizenetaim.extendCancelRequest');
});

it('authorizenet: cancels authorized payment failed', function(): void {
    Event::fake();

    $paymentLog = mock(PaymentLog::class)->makePartial();
    $paymentLog->is_success = true;
    $paymentLog->response = ['id' => '12345'];

    $order = mock(Order::class)->makePartial();
    $order->hash = 'order_hash';
    $order->shouldReceive('logPaymentAttempt')->with('Canceling payment failed', 0, [], Mockery::any())->once();
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturn($paymentLog)
        ->once();

    $messageAType = (new MessageAType)->setCode('1')->setDescription('Success');
    $response = mock(TransactionResponseType::class);
    $response->shouldReceive('getResponseCode')->andReturn('2')->twice();
    $response->shouldReceive('getTransId')->andReturn('54321')->once();
    $response->shouldReceive('getMessages')->andReturn([$messageAType])->twice();
    $response->shouldReceive('getAccountNumber')->andReturn('****1111')->once();
    $response->shouldReceive('getAccountType')->andReturn('Visa')->once();
    $response->shouldReceive('getAuthCode')->andReturn('auth123')->once();
    $request = mock(AuthorizeNetTransactionRequest::class);
    $authorizeClient = mock(AuthorizeNetClient::class)->makePartial();
    $authorizeClient->shouldReceive('createTransactionRequest')->andReturn($request);
    $authorizeClient->shouldReceive('createTransaction')->andReturn($response);
    app()->instance(AuthorizeNetClient::class, $authorizeClient);

    $expectedResponse = $this->authorizeNetAim->cancelAuthorizedPayment($order);

    expect($response)->toEqual($expectedResponse);
    Event::assertDispatched('payregister.authorizenetaim.extendCancelRequest');
});

it('authorizenet: throws exception if no successful transaction to cancel', function(): void {
    $order = mock(Order::class)->makePartial();
    $order->shouldReceive('payment_logs->firstWhere')
        ->with('is_success', true)
        ->andReturnNull()
        ->once();

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('No successful transaction to capture');

    $this->authorizeNetAim->cancelAuthorizedPayment($order);
});
