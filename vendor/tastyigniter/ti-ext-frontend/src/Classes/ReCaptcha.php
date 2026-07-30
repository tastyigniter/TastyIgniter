<?php

declare(strict_types=1);

namespace Igniter\Frontend\Classes;

use GuzzleHttp\Client;

class ReCaptcha
{
    /**
     * The API request URI
     */
    public const string API_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    protected $httpClient;

    /**
     * ReCaptcha constructor.
     *
     * @param string $secretKey
     * @param string $version
     */
    public function __construct(protected $secretKey, protected $version = 'v2') {}

    public function setHttpClient(mixed $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient ?? new Client;
    }

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $response
     * @param string $clientIp
     *
     * @return bool
     */
    public function verifyResponse($response, $clientIp = null)
    {
        if (empty($response)) {
            return false;
        }

        if (is_null($clientIp)) {
            $clientIp = request()->getClientIp();
        }

        $httpResponse = $this->getHttpClient()->post(static::API_VERIFY_URL, [
            'form_params' => $this->buildRequestQuery($response, $clientIp),
        ]);

        $parsedResponse = json_decode((string)$httpResponse->getBody(), true);

        return isset($parsedResponse['success']) && $parsedResponse['success'] === true;
    }

    protected function buildRequestQuery($response, $clientIp): array
    {
        return [
            'secret' => $this->secretKey,
            'response' => $response,
            'remoteip' => $clientIp,
        ];
    }
}
