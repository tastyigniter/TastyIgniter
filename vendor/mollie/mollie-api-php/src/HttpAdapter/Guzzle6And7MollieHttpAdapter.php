<?php

namespace Mollie\Api\HttpAdapter;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Mollie\Api\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

final class Guzzle6And7MollieHttpAdapter implements MollieHttpAdapterInterface
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
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * Whether debugging is enabled. If debugging mode is enabled, the request will
     * be included in the ApiException. By default, debugging is disabled to prevent
     * sensitive request data from leaking into exception logs.
     *
     * @var bool
     */
    protected $debugging = false;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Instantiate a default adapter with sane configuration for Guzzle 6 or 7.
     *
     * @return static
     */
    public static function createDefault()
    {
        $retryMiddlewareFactory = new Guzzle6And7RetryMiddlewareFactory;
        $handlerStack = HandlerStack::create();
        $handlerStack->push($retryMiddlewareFactory->retry());

        $client = new Client([
            GuzzleRequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
            GuzzleRequestOptions::TIMEOUT => self::DEFAULT_TIMEOUT,
            GuzzleRequestOptions::CONNECT_TIMEOUT => self::DEFAULT_CONNECT_TIMEOUT,
            'handler' => $handlerStack,
        ]);

        return new Guzzle6And7MollieHttpAdapter($client);
    }

    /**
     * Send a request to the specified Mollie api url.
     *
     * @param string $httpMethod
     * @param string $url
     * @param array $headers
     * @param string $httpBody
     * @return \stdClass|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function send($httpMethod, $url, $headers, $httpBody)
    {
        $request = new Request($httpMethod, $url, $headers, $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            // Prevent sensitive request data from ending up in exception logs unintended
            if (! $this->debugging) {
                $request = null;
            }

            // Not all Guzzle Exceptions implement hasResponse() / getResponse()
            if (method_exists($e, 'hasResponse') && method_exists($e, 'getResponse')) {
                if ($e->hasResponse()) {
                    throw ApiException::createFromResponse($e->getResponse(), $request);
                }
            }

            throw new ApiException($e->getMessage(), $e->getCode(), null, $request, null);
        }

        return $this->parseResponseBody($response);
    }

    /**
     * Whether this http adapter provides a debugging mode. If debugging mode is enabled, the
     * request will be included in the ApiException.
     *
     * @return true
     */
    public function supportsDebugging()
    {
        return true;
    }

    /**
     * Whether debugging is enabled. If debugging mode is enabled, the request will
     * be included in the ApiException. By default, debugging is disabled to prevent
     * sensitive request data from leaking into exception logs.
     *
     * @return bool
     */
    public function debugging()
    {
        return $this->debugging;
    }

    /**
     * Enable debugging. If debugging mode is enabled, the request will
     * be included in the ApiException. By default, debugging is disabled to prevent
     * sensitive request data from leaking into exception logs.
     */
    public function enableDebugging()
    {
        $this->debugging = true;
    }

    /**
     * Disable debugging. If debugging mode is enabled, the request will
     * be included in the ApiException. By default, debugging is disabled to prevent
     * sensitive request data from leaking into exception logs.
     */
    public function disableDebugging()
    {
        $this->debugging = false;
    }

    /**
     * Parse the PSR-7 Response body
     *
     * @param ResponseInterface $response
     * @return \stdClass|null
     * @throws ApiException
     */
    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string) $response->getBody();

        if (empty($body) && $response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return null;
        }

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode Mollie response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::createFromResponse($response, null);
        }

        return $object;
    }

    /**
     * The version number for the underlying http client, if available. This is used to report the UserAgent to Mollie,
     * for convenient support.
     * @example Guzzle/6.3
     *
     * @return string|null
     */
    public function versionString()
    {
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) { // Guzzle 7
            return "Guzzle/" . ClientInterface::MAJOR_VERSION;
        } elseif (defined('\GuzzleHttp\ClientInterface::VERSION')) { // Before Guzzle 7
            return "Guzzle/" . ClientInterface::VERSION;
        }

        return null;
    }
}
