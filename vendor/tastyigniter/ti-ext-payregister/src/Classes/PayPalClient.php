<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PayPalClient
{
    protected ?string $clientId = null;

    protected ?string $clientSecret = null;

    protected bool $sandbox = false;

    public function setClientId(?string $clientId): PayPalClient
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function setClientSecret(?string $clientSecret): PayPalClient
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    public function setSandbox(bool $sandbox): PayPalClient
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    public function getOrder(string $orderId)
    {
        return Http::asJson()->withHeaders([
            'Authorization' => $this->generateAccessToken(),
        ])->get($this->endpoint('v2/checkout/orders/'.$orderId));
    }

    public function createOrder($params)
    {
        return Http::asJson()
            ->withHeaders($this->prepareHeaders())
            ->post($this->endpoint('v2/checkout/orders'), $params);
    }

    public function captureOrder(string $orderId)
    {
        return Http::contentType('application/json')
            ->withHeaders($this->prepareHeaders())
            ->send('POST', $this->endpoint('v2/checkout/orders/'.$orderId.'/capture'));
    }

    public function authorizeOrder(string $orderId)
    {
        return Http::contentType('application/json')
            ->withHeaders($this->prepareHeaders())
            ->send('POST', $this->endpoint('v2/checkout/orders/'.$orderId.'/authorize'));
    }

    public function getPayment(string $id)
    {
        return Http::asJson()->withHeaders([
            'Authorization' => $this->generateAccessToken(),
        ])->get($this->endpoint('v1/payments/capture/'.$id));
    }

    public function refundPayment(string $id, $params)
    {
        return Http::asJson()
            ->withHeaders($this->prepareHeaders())
            ->post($this->endpoint('v2/payments/captures/'.$id.'/refund'), $params);
    }

    protected function generateAccessToken(): string
    {
        throw_unless($this->clientId, ApplicationException::class, 'PayPal client ID is not configured');
        throw_unless($this->clientSecret, ApplicationException::class, 'PayPal client secret is not configured');

        $cacheKey = 'payregister_paypal_access_token'.($this->sandbox ? '_sandbox' : '');

        if (!cache()->has($cacheKey)) {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post($this->endpoint('v1/oauth2/token'), [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->json('access_token')) {
                throw new ApplicationException('Failed to generate access token');
            }

            cache()->put($cacheKey, $response->json('access_token'), $response->json('expires_in') - 60);
        }

        return 'Bearer '.cache()->get($cacheKey);
    }

    protected function endpoint(string $uri): string
    {
        $endpoint = 'https://';
        $endpoint .= $this->sandbox ? 'api-m.sandbox.paypal.com/' : 'api-m.paypal.com/';

        return $endpoint.$uri;
    }

    protected function prepareHeaders(): array
    {
        return [
            'Authorization' => $this->generateAccessToken(),
            'PayPal-Request-Id' => Str::uuid()->toString(),
        ];
    }
}
