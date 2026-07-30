<?php

declare(strict_types=1);

namespace Unirest;

use CoreInterfaces\Http\HttpConfigurations;

class Configuration
{
    /**
     * @var string|null
     */
    private $cookie;
    /**
     * @var string|null
     */
    private $cookieFile;
    private $curlOpts = [];
    private $jsonOpts = [];
    private $socketTimeout = 0;
    private $enableRetries = false;       // should we enable retries feature
    private $maxNumberOfRetries = 3;      // total number of allowed retries
    private $retryOnTimeout = false;      // Should we retry on timeout?
    private $retryInterval = 1.0;         // Initial retry interval in seconds, to be increased by backoffFactor
    private $maximumRetryWaitTime = 120;  // maximum retry wait time (commutative)
    private $backoffFactor = 2.0;         // backoff factor to be used to increase retry interval
    private $httpStatusCodesToRetry = [408, 413, 429, 500, 502, 503, 504, 521, 522, 524];
    private $httpMethodsToRetry = ["GET", "PUT"];
    private $verifyPeer = true;
    private $verifyHost = true;
    private $defaultHeaders = [];

    private $auth =  [
        'user' => '',
        'pass' => '',
        'method' => CURLAUTH_BASIC
    ];

    private $proxy = [
        'port' => false,
        'tunnel' => false,
        'address' => false,
        'type' => CURLPROXY_HTTP,
        'auth' =>  [
            'user' => '',
            'pass' => '',
            'method' => CURLAUTH_BASIC
        ]
    ];

    public static function init(?HttpConfigurations $httpConfigurations = null): self
    {
        return new self($httpConfigurations);
    }

    private function __construct(?HttpConfigurations $httpConfigurations)
    {
        if (is_null($httpConfigurations)) {
            return;
        }
        $this->timeout($httpConfigurations->getTimeout())
            ->enableRetries($httpConfigurations->shouldEnableRetries())
            ->maxNumberOfRetries($httpConfigurations->getNumberOfRetries())
            ->retryOnTimeout($httpConfigurations->shouldRetryOnTimeout())
            ->retryInterval($httpConfigurations->getRetryInterval())
            ->maximumRetryWaitTime($httpConfigurations->getMaximumRetryWaitTime())
            ->backoffFactor($httpConfigurations->getBackOffFactor())
            ->httpStatusCodesToRetry($httpConfigurations->getHttpStatusCodesToRetry())
            ->httpMethodsToRetry($httpConfigurations->getHttpMethodsToRetry());
    }

    /**
     * @param int $socketTimeout Timeout for API calls in seconds.
     */
    public function timeout(int $socketTimeout): self
    {
        $this->socketTimeout = $socketTimeout;
        return $this;
    }

    /**
     * @param bool $enableRetries Whether to enable retries and backoff feature.
     */
    public function enableRetries(bool $enableRetries): self
    {
        $this->enableRetries = $enableRetries;
        return $this;
    }

    /**
     * @param int $maxNumberOfRetries The number of retries to make.
     */
    public function maxNumberOfRetries(int $maxNumberOfRetries): self
    {
        $this->maxNumberOfRetries = $maxNumberOfRetries;
        return $this;
    }

    /**
     * @param bool $retryOnTimeout Whether to retry on timeout
     */
    public function retryOnTimeout(bool $retryOnTimeout): self
    {
        $this->retryOnTimeout = $retryOnTimeout;
        return $this;
    }

    /**
     * @param float $retryInterval The retry time interval between the endpoint calls.
     */
    public function retryInterval(float $retryInterval): self
    {
        $this->retryInterval = $retryInterval;
        return $this;
    }

    /**
     * @param int $maximumRetryWaitTime The maximum wait time in seconds for overall retrying requests.
     */
    public function maximumRetryWaitTime(int $maximumRetryWaitTime): self
    {
        $this->maximumRetryWaitTime = $maximumRetryWaitTime;
        return $this;
    }

    /**
     * @param float $backoffFactor Exponential backoff factor to increase interval between retries.
     */
    public function backoffFactor(float $backoffFactor): self
    {
        $this->backoffFactor = $backoffFactor;
        return $this;
    }

    /**
     * @param int[] $httpStatusCodesToRetry Http status codes to retry against.
     */
    public function httpStatusCodesToRetry(array $httpStatusCodesToRetry): self
    {
        $this->httpStatusCodesToRetry = $httpStatusCodesToRetry;
        return $this;
    }

    /**
     * @param string[] $httpMethodsToRetry Http methods to retry against.
     */
    public function httpMethodsToRetry(array $httpMethodsToRetry): self
    {
        $this->httpMethodsToRetry = $httpMethodsToRetry;
        return $this;
    }

    /**
     * Set JSON decode mode
     *
     * @param bool $assoc When TRUE, returned objects will be converted into associative arrays.
     * @param int $depth User specified recursion depth.
     * @param int $options Bitmask of JSON decode options. Currently only JSON_BIGINT_AS_STRING is supported
     *                     (default is to cast large integers as floats)
     */
    public function jsonOpts(bool $assoc = false, int $depth = 512, int $options = 0): self
    {
        $this->jsonOpts = [$assoc, $depth, $options];
        return $this;
    }

    /**
     * Verify SSL peer
     *
     * @param bool $enabled enable SSL verification, by default is true
     */
    public function verifyPeer(bool $enabled): self
    {
        $this->verifyPeer = $enabled;
        return $this;
    }

    /**
     * Verify SSL host
     *
     * @param bool $enabled enable SSL host verification, by default is true
     */
    public function verifyHost(bool $enabled): self
    {
        $this->verifyHost = $enabled;
        return $this;
    }

    /**
     * Set default headers to send on every request
     *
     * @param array $headers headers array
     */
    public function defaultHeaders(array $headers): self
    {
        $this->defaultHeaders = array_merge($this->defaultHeaders, $headers);
        return $this;
    }

    /**
     * Set a new default header to send on every request
     *
     * @param string $name header name
     * @param string $value header value
     */
    public function defaultHeader(string $name, string $value): self
    {
        $this->defaultHeaders[$name] = $value;
        return $this;
    }

    /**
     * Set curl options to send on every request
     *
     * @param array $options options array
     */
    public function curlOpts(array $options): self
    {
        $this->curlOpts = array_merge($this->curlOpts, $options);
        return $this;
    }

    /**
     * Set a new default header to send on every request
     *
     * @param string|int $name header name
     * @param string $value header value
     */
    public function curlOpt($name, string $value): self
    {
        $this->curlOpts[$name] = $value;
        return $this;
    }

    /**
     * Set a cookie string for enabling cookie handling
     *
     * @param string $cookie
     */
    public function cookie(string $cookie): self
    {
        $this->cookie = $cookie;
        return $this;
    }

    /**
     * Set a cookie file path for enabling cookie handling
     *
     * $cookieFile must be a correct path with write permission
     *
     * @param string $cookieFile - path to file for saving cookie
     */
    public function cookieFile(string $cookieFile): self
    {
        $this->cookieFile = $cookieFile;
        return $this;
    }

    /**
     * Set authentication method to use
     *
     * @param string $username authentication username
     * @param string $password authentication password
     * @param integer $method authentication method
     */
    public function auth(string $username = '', string $password = '', int $method = CURLAUTH_BASIC): self
    {
        $this->auth['user'] = $username;
        $this->auth['pass'] = $password;
        $this->auth['method'] = $method;
        return $this;
    }

    /**
     * Set proxy to use
     *
     * @param string $address proxy address
     * @param integer $port proxy port
     * @param integer $type (Available options for this are CURLPROXY_HTTP, CURLPROXY_HTTP_1_0 CURLPROXY_SOCKS4,
     *                      CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A and CURLPROXY_SOCKS5_HOSTNAME)
     * @param bool $tunnel enable/disable tunneling
     */
    public function proxy(string $address, int $port = 1080, int $type = CURLPROXY_HTTP, bool $tunnel = false): self
    {
        $this->proxy['type'] = $type;
        $this->proxy['port'] = $port;
        $this->proxy['tunnel'] = $tunnel;
        $this->proxy['address'] = $address;
        return $this;
    }

    public function proxyConfiguration(array $proxyConfiguration): self
    {
        $this->proxy = array_merge($this->proxy, $proxyConfiguration);
        return $this;
    }
    /**
     * Set proxy authentication method to use
     *
     * @param string $username authentication username
     * @param string $password authentication password
     * @param integer $method authentication method
     */
    public function proxyAuth(string $username = '', string $password = '', int $method = CURLAUTH_BASIC): self
    {
        $this->proxy['auth']['user'] = $username;
        $this->proxy['auth']['pass'] = $password;
        $this->proxy['auth']['method'] = $method;
        return $this;
    }

    public function getTimeout(): int
    {
        return $this->socketTimeout;
    }

    public function shouldEnableRetries(): bool
    {
        return $this->enableRetries;
    }

    public function getNumberOfRetries(): int
    {
        return $this->maxNumberOfRetries;
    }

    public function getRetryInterval(): float
    {
        return $this->retryInterval;
    }

    public function getBackOffFactor(): float
    {
        return $this->backoffFactor;
    }

    public function getMaximumRetryWaitTime(): int
    {
        return $this->maximumRetryWaitTime;
    }

    public function shouldRetryOnTimeout(): bool
    {
        return $this->retryOnTimeout;
    }

    public function getHttpStatusCodesToRetry(): array
    {
        return $this->httpStatusCodesToRetry;
    }

    public function getHttpMethodsToRetry(): array
    {
        return $this->httpMethodsToRetry;
    }

    public function getCookie(): ?string
    {
        return $this->cookie;
    }

    public function getCookieFile(): ?string
    {
        return $this->cookieFile;
    }

    public function getCurlOpts(): array
    {
        return $this->curlOpts;
    }

    public function getJsonOpts(): array
    {
        return $this->jsonOpts;
    }

    public function shouldVerifyPeer(): bool
    {
        return $this->verifyPeer;
    }

    public function shouldVerifyHost(): bool
    {
        return $this->verifyHost;
    }

    public function getDefaultHeaders(): array
    {
        return $this->defaultHeaders;
    }

    public function getAuth(): array
    {
        return $this->auth;
    }

    public function getProxy(): array
    {
        return $this->proxy;
    }
}
