<?php

namespace Mollie\Api\HttpAdapter;

use Composer\CaBundle\CaBundle;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Exceptions\CurlConnectTimeoutException;
use Mollie\Api\MollieApiClient;

final class CurlMollieHttpAdapter implements MollieHttpAdapterInterface
{
    /**
     * Default response timeout (in seconds).
     */
    public const DEFAULT_TIMEOUT = 10;

    /**
     * Default connect timeout (in seconds).
     */
    public const DEFAULT_CONNECT_TIMEOUT = 2;

    /**
     * The maximum number of retries
     */
    public const MAX_RETRIES = 5;

    /**
     * The amount of milliseconds the delay is being increased with on each retry.
     */
    public const DELAY_INCREASE_MS = 1000;

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $headers
     * @param string $httpBody
     * @return \stdClass|void|null
     * @throws \Mollie\Api\Exceptions\ApiException
     * @throws \Mollie\Api\Exceptions\CurlConnectTimeoutException
     */
    public function send($httpMethod, $url, $headers, $httpBody)
    {
        for ($i = 0; $i <= self::MAX_RETRIES; $i++) {
            usleep($i * self::DELAY_INCREASE_MS);

            try {
                return $this->attemptRequest($httpMethod, $url, $headers, $httpBody);
            } catch (CurlConnectTimeoutException $e) {
                // Nothing
            }
        }

        throw new CurlConnectTimeoutException(
            "Unable to connect to Mollie. Maximum number of retries (". self::MAX_RETRIES .") reached."
        );
    }

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $headers
     * @param string $httpBody
     * @return \stdClass|void|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    protected function attemptRequest($httpMethod, $url, $headers, $httpBody)
    {
        $curl = curl_init($url);
        $headers["Content-Type"] = "application/json";

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->parseHeaders($headers));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::DEFAULT_CONNECT_TIMEOUT);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::DEFAULT_TIMEOUT);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, CaBundle::getBundledCaBundlePath());

        switch ($httpMethod) {
            case MollieApiClient::HTTP_POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $httpBody);

                break;
            case MollieApiClient::HTTP_GET:
                break;
            case MollieApiClient::HTTP_PATCH:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $httpBody);

                break;
            case MollieApiClient::HTTP_DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $httpBody);

                break;
            default:
                throw new \InvalidArgumentException("Invalid http method: ". $httpMethod);
        }

        $startTime = microtime(true);
        $response = curl_exec($curl);
        $endTime = microtime(true);

        if ($response === false) {
            $executionTime = $endTime - $startTime;
            $curlErrorNumber = curl_errno($curl);
            $curlErrorMessage = "Curl error: " . curl_error($curl);

            if ($this->isConnectTimeoutError($curlErrorNumber, $executionTime)) {
                throw new CurlConnectTimeoutException("Unable to connect to Mollie. " . $curlErrorMessage);
            }

            throw new ApiException($curlErrorMessage);
        }

        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        return $this->parseResponseBody($response, $statusCode, $httpBody);
    }

    /**
     * The version number for the underlying http client, if available.
     * @example Guzzle/6.3
     *
     * @return string|null
     */
    public function versionString()
    {
        return 'Curl/*';
    }

    /**
     * Whether this http adapter provides a debugging mode. If debugging mode is enabled, the
     * request will be included in the ApiException.
     *
     * @return false
     */
    public function supportsDebugging()
    {
        return false;
    }

    /**
     * @param int $curlErrorNumber
     * @param string|float $executionTime
     * @return bool
     */
    protected function isConnectTimeoutError($curlErrorNumber, $executionTime)
    {
        $connectErrors = [
            \CURLE_COULDNT_RESOLVE_HOST => true,
            \CURLE_COULDNT_CONNECT => true,
            \CURLE_SSL_CONNECT_ERROR => true,
            \CURLE_GOT_NOTHING => true,
        ];

        if (isset($connectErrors[$curlErrorNumber])) {
            return true;
        };

        if ($curlErrorNumber === \CURLE_OPERATION_TIMEOUTED) {
            if ($executionTime > self::DEFAULT_TIMEOUT) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param string $response
     * @param int $statusCode
     * @param string $httpBody
     * @return \stdClass|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    protected function parseResponseBody($response, $statusCode, $httpBody)
    {
        if (empty($response) && $statusCode >= 200 && $statusCode < 300) {
            return null;
        }

        $body = @json_decode($response);

        // GUARDS
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode Mollie response: '{$response}'.");
        }

        if (isset($body->error)) {
            throw new ApiException($body->error->message);
        }

        if ($statusCode >= 400) {
            $message = "Error executing API call ({$body->status}: {$body->title}): {$body->detail}";

            $field = null;

            if (! empty($body->field)) {
                $field = $body->field;
            }

            if (isset($body->_links, $body->_links->documentation)) {
                $message .= ". Documentation: {$body->_links->documentation->href}";
            }

            if ($httpBody) {
                $message .= ". Request body: {$httpBody}";
            }

            throw new ApiException($message, $statusCode, $field);
        }

        return $body;
    }

    protected function parseHeaders($headers)
    {
        $result = [];

        foreach ($headers as $key => $value) {
            $result[] = $key .': ' . $value;
        }

        return $result;
    }
}
