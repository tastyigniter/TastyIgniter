<?php

namespace Unirest\Request;

use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Request\RequestMethod;
use CoreInterfaces\Http\RetryOption;
use Exception;
use InvalidArgumentException;

class Request implements RequestInterface
{
    /**
     * This function is useful for serializing multidimensional arrays, and avoid getting
     * the 'Array to string conversion' notice
     * @param array|object $data array to flatten.
     * @param bool|string $parent parent key or false if no parent
     */
    public static function buildHTTPCurlQuery($data, $parent = false): array
    {
        $result = [];

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        foreach ($data as $key => $value) {
            if (!empty($parent)) {
                $new_key = sprintf('%s[%s]', $parent, $key);
            } else {
                $new_key = $key;
            }

            if (!$value instanceof \CURLFile and (is_array($value) or is_object($value))) {
                $result = array_merge($result, self::buildHTTPCurlQuery($value, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }
        return $result;
    }

    private $httpMethod;
    private $queryUrl;
    private $headers;
    private $body;
    private $retryOption;

    /**
     * @param string $url         Query url
     * @param string $method      Http method
     * @param array  $headers     Http request headers
     * @param mixed  $body        Http request body
     * @param string $retryOption To enable/disable httpMethods whitelist while retrying Api call
     */
    public function __construct(
        string $url,
        string $method = RequestMethod::GET,
        array $headers = [],
        $body = null,
        string $retryOption = RetryOption::USE_GLOBAL_SETTINGS
    ) {
        $this->queryUrl = $this->validateUrl($url);
        $this->httpMethod = $method;
        $this->headers = $headers;
        $this->body = $body;
        $this->retryOption = $retryOption;
    }

    /**
     * Validates and processes the given Url to ensure safe usage with cURL.
     * @param string $url The given Url to process
     * @return string Pre-processed Url as string
     * @throws InvalidArgumentException
     */
    private function validateUrl(string $url): string
    {
        //ensure that the urls are absolute
        $matchCount = preg_match("#^(https?://[^/]+)#", $url, $matches);
        if ($matchCount == 0) {
            throw new InvalidArgumentException('Invalid Url format.');
        }
        //get the http protocol match
        $protocol = $matches[1];

        //remove redundant forward slashes
        $query = substr($url, strlen($protocol));
        $query = preg_replace("#//+#", "/", $query);

        //return process url
        return $protocol . $query;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getQueryUrl(): string
    {
        return $this->queryUrl;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function getEncodedParameters(): array
    {
        return [];
    }

    public function getMultipartParameters(): array
    {
        return [];
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getRetryOption(): string
    {
        return $this->retryOption;
    }

    public function convert(): Request
    {
        return $this;
    }

    public function toApiException(string $message): Exception
    {
        return new Exception($message);
    }
}
