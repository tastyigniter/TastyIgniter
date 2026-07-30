<?php

declare(strict_types=1);

namespace Core\Types\Sdk;

abstract class CoreApiResponse
{
    protected $request;

    /**
     * @var int|null
     */
    private $statusCode;

    /**
     * @var string|null
     */
    private $reasonPhrase;

    /**
     * @var array|null
     */
    private $headers;
    private $result;
    private $body;

    public function __construct($request, ?int $statusCode, ?string $reasonPhrase, ?array $headers, $result, $body)
    {
        $this->request = $request;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->headers = $headers;
        $this->result = $result;
        $this->body = $body;
    }

    /**
     * Returns the original request that resulted in this response.
     */
    abstract public function getRequest();

    /**
     * Returns the response status code.
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Returns the HTTP reason phrase from the response.
     */
    public function getReasonPhrase(): ?string
    {
        return $this->reasonPhrase;
    }

    /**
     * Returns the response headers.
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * Returns the response data.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Returns the original body from the response.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Is response OK?
     */
    public function isSuccess(): bool
    {
        if ($this->statusCode == null) {
            return false;
        }
        if ($this->statusCode < 200) {
            return false;
        }
        if ($this->statusCode > 299) {
            return false;
        }
        return true;
    }

    /**
     * Is response missing or not OK?
     */
    public function isError(): bool
    {
        return !$this->isSuccess();
    }
}
