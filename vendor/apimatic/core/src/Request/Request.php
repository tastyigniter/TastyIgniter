<?php

declare(strict_types=1);

namespace Core\Request;

use Closure;
use Core\Client;
use Core\Types\Sdk\CoreFileWrapper;
use Core\Utils\CoreHelper;
use CoreInterfaces\Core\Format;
use CoreInterfaces\Core\Request\RequestMethod;
use CoreInterfaces\Core\Request\RequestSetterInterface;
use CoreInterfaces\Http\RetryOption;

class Request implements RequestSetterInterface
{
    private $converter;
    private $queryUrl;
    private $requestMethod = RequestMethod::GET;
    private $headers = [];
    private $parameters = [];
    private $parametersEncoded = [];
    private $parametersMultipart = [];
    private $body;
    private $retryOption = RetryOption::USE_GLOBAL_SETTINGS;
    private $allowContentType = true;

    /**
     * Creates a new Request object.
     */
    public function __construct(string $queryUrl, ?Client $client = null)
    {
        $this->queryUrl = CoreHelper::validateUrl($queryUrl);
        $this->converter = Client::getConverter($client);
    }

    /**
     * Returns the http method to be used for the call.
     */
    public function getHttpMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * Returns the query URL for the request.
     */
    public function getQueryUrl(): string
    {
        return $this->queryUrl;
    }

    /**
     * Returns the headers associated with the request.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Returns the parameters for the request.
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Returns encoded parameters associated the request.
     */
    public function getEncodedParameters(): array
    {
        return $this->parametersEncoded;
    }

    /**
     * Returns multipart parameters associated with the request.
     */
    public function getMultipartParameters(): array
    {
        return $this->parametersMultipart;
    }

    /**
     * Returns body associated with the request.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Returns the state of retryOption for the request.
     */
    public function getRetryOption(): string
    {
        return $this->retryOption;
    }

    /**
     * Converts the request to HttpRequest.
     */
    public function convert()
    {
        return $this->converter->createHttpRequest($this);
    }

    /**
     * Creates an ApiException with the message provided.
     */
    public function toApiException(string $message)
    {
        return $this->converter->createApiException($message, $this, null);
    }

    /**
     * Adds accept header to the request.
     */
    public function addAcceptHeader(string $accept): void
    {
        if (!$this->allowContentType) {
            return;
        }
        if ($accept == Format::SCALAR) {
            return;
        }
        $this->addHeader('Accept', $accept);
    }

    /**
     * Sets the Http Method to be used for current request.
     */
    public function setHttpMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * Appends path to the query URL.
     */
    public function appendPath(string $path): void
    {
        $this->queryUrl .= $path;
    }

    /**
     * Add or replace a single header
     *
     * @param string $key  key for the header
     * @param mixed $value value of the header
     */
    public function addHeader(string $key, $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Adds template param value to the query URL, corresponding to the key provided.
     */
    public function addTemplate(string $key, $value): void
    {
        $this->queryUrl = str_replace("{{$key}}", $value, $this->queryUrl);
    }

    /**
     * Adds an encoded form param to the request.
     */
    public function addEncodedFormParam(string $key, $value, $realValue): void
    {
        $this->parametersEncoded[$key] = $value;
        $this->parameters[$key] = $realValue;
    }

    /**
     * Adds a multipart form param to the request.
     */
    public function addMultipartFormParam(string $key, $value): void
    {
        $this->parametersMultipart[$key] = $value;
        $this->parameters[$key] = $value;
    }

    /**
     * Adds a body param to the current request.
     */
    public function addBodyParam($value, string $key = ''): void
    {
        if (empty($key)) {
            $this->body = $value;
            return;
        }
        if (is_array($this->body)) {
            $this->body[$key] = $value;
        } else {
            $this->body = [$key => $value];
        }
    }

    private function addContentType(string $format): void
    {
        if (!$this->allowContentType) {
            return;
        }
        if (array_key_exists('content-type', array_change_key_case($this->headers))) {
            return;
        }
        // if request has body, and content-type header is not already added
        // then add content-type, based on type and format of body
        if ($this->body instanceof CoreFileWrapper) {
            $this->addHeader('content-type', 'application/octet-stream');
            return;
        }
        if ($format != Format::JSON) {
            $this->addHeader('content-type', $format);
            return;
        }
        if (is_array($this->body)) {
            $this->addHeader('content-type', Format::JSON);
            return;
        }
        if (is_object($this->body)) {
            $this->addHeader('content-type', Format::JSON);
            return;
        }
        $this->addHeader('content-type', Format::SCALAR);
    }

    /**
     * Sets body format for the request and returns the body in a serialized format.
     */
    public function setBodyFormat(string $format, callable $serializer): void
    {
        if (!empty($this->parameters)) {
            return;
        }

        if (is_null($this->body)) {
            return;
        }

        $this->addContentType($format);
        $this->body = Closure::fromCallable($serializer)($this->body);
    }

    /**
     * Sets value for retryOption for the request.
     */
    public function setRetryOption(string $retryOption): void
    {
        $this->retryOption = $retryOption;
    }

    /**
     * Sets if the request has an allowContentType header or not.
     */
    public function shouldAddContentType(bool $allowContentType): void
    {
        $this->allowContentType = $allowContentType;
    }
}
