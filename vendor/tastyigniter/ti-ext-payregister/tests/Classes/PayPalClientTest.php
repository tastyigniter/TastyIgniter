<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\PayPalClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function(): void {
    $this->clientId = 'testClientId';
    $this->clientSecret = 'testClientSecret';
    $this->sandbox = true;
    $this->payPalClient = new PayPalClient;
    $this->payPalClient->setClientSecret($this->clientSecret);
    $this->payPalClient->setClientId($this->clientId);
    $this->payPalClient->setSandbox($this->sandbox);
});

function mockGenerateAccessToken(): void
{
    Cache::shouldReceive('has')->with('payregister_paypal_access_token_sandbox')->andReturn(false);
    Cache::shouldReceive('put')->once();
    Cache::shouldReceive('get')->with('payregister_paypal_access_token_sandbox')->andReturn('testAccessToken');

    Http::fake([
        'https://api-m.sandbox.paypal.com/v1/oauth2/token' => Http::response([
            'access_token' => 'testAccessToken',
            'expires_in' => 3600,
        ], 200),
    ]);
}

it('throws exception if client ID is not configured', function(): void {
    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('PayPal client ID is not configured');

    $paypalClient = new PayPalClient;
    $paypalClient->setClientSecret('testClientSecret');
    $paypalClient->getOrder('123');
});

it('throws exception if client secret is not configured', function(): void {
    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('PayPal client secret is not configured');

    $paypalClient = new PayPalClient;
    $paypalClient->setClientId('testClientId');
    $paypalClient->getOrder('123');
});

it('gets order details successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v2/checkout/orders/*' => Http::response(['id' => 'testOrderId'], 200),
    ]);

    $response = $this->payPalClient->getOrder('testOrderId');

    expect($response->json('id'))->toBe('testOrderId');
});

it('creates order successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v2/checkout/orders' => Http::response(['id' => 'testOrderId'], 201),
    ]);

    $response = $this->payPalClient->createOrder(['intent' => 'CAPTURE']);

    expect($response->json('id'))->toBe('testOrderId');
});

it('captures order successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v2/checkout/orders/testOrderId/capture' => Http::response(['status' => 'COMPLETED'], 200),
    ]);

    $response = $this->payPalClient->captureOrder('testOrderId');

    expect($response->json('status'))->toBe('COMPLETED');
});

it('authorizes order successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v2/checkout/orders/testOrderId/authorize' => Http::response(['status' => 'AUTHORIZED'], 200),
    ]);

    $response = $this->payPalClient->authorizeOrder('testOrderId');

    expect($response->json('status'))->toBe('AUTHORIZED');
});

it('gets payment details successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v1/payments/capture/*' => Http::response(['id' => 'testPaymentId'], 200),
    ]);

    $response = $this->payPalClient->getPayment('testPaymentId');

    expect($response->json('id'))->toBe('testPaymentId');
});

it('refunds payment successfully', function(): void {
    mockGenerateAccessToken();

    Http::fake([
        'https://api-m.sandbox.paypal.com/v2/payments/captures/testPaymentId/refund' => Http::response(['status' => 'COMPLETED'], 201),
    ]);

    $response = $this->payPalClient->refundPayment('testPaymentId', ['amount' => ['value' => '10.00', 'currency_code' => 'USD']]);

    expect($response->json('status'))->toBe('COMPLETED');
});

it('throws exception if access token generation fails', function(): void {
    Cache::shouldReceive('has')->with('payregister_paypal_access_token_sandbox')->andReturn(false);

    Http::fake([
        'https://api-m.sandbox.paypal.com/v1/oauth2/token' => Http::response([], 400),
    ]);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Failed to generate access token');

    $this->payPalClient->getOrder('123');
});

it('targets the live api host when not in sandbox mode', function(): void {
    Cache::shouldReceive('has')->with('payregister_paypal_access_token')->andReturn(false);
    Cache::shouldReceive('put')->once();
    Cache::shouldReceive('get')->with('payregister_paypal_access_token')->andReturn('testAccessToken');

    Http::fake([
        'https://api-m.paypal.com/v1/oauth2/token' => Http::response([
            'access_token' => 'testAccessToken',
            'expires_in' => 3600,
        ], 200),
        'https://api-m.paypal.com/v2/checkout/orders/*' => Http::response(['id' => 'testOrderId'], 200),
    ]);

    $client = new PayPalClient;
    $client->setClientId('testClientId');
    $client->setClientSecret('testClientSecret');
    $client->setSandbox(false);

    $response = $client->getOrder('testOrderId');

    expect($response->json('id'))->toBe('testOrderId');
});
