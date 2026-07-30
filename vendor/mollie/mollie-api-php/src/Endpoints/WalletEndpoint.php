<?php

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\BaseResource;

class WalletEndpoint extends EndpointAbstract
{
    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return void|BaseResource
     */
    protected function getResourceObject()
    {
        // Not used
    }

    /**
     * Obtain a new ApplePay payment session.
     *
     * @param string $domain
     * @param string $validationUrl
     * @param array $parameters
     *
     * @return false|string
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function requestApplePayPaymentSession($domain, $validationUrl, $parameters = [])
    {
        $body = $this->parseRequestBody(array_merge([
            'domain' => $domain,
            'validationUrl' => $validationUrl,
        ], $parameters));

        $response = $this->client->performHttpCall(
            self::REST_CREATE,
            'wallets/applepay/sessions',
            $body
        );

        return json_encode($response);
    }
}
