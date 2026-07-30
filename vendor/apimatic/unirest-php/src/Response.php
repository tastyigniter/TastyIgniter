<?php

declare(strict_types=1);

namespace Unirest;

use CoreInterfaces\Core\Response\ResponseInterface;
use CoreInterfaces\Sdk\ConverterInterface;

class Response implements ResponseInterface
{
    private $code;
    private $raw_body;
    private $body;
    private $headers;

    /**
     * @param int $code        response code of the cURL request
     * @param string $raw_body the raw body of the cURL response
     * @param array $headers   parsed headers array from cURL response
     * @param array $json_args arguments to pass to json_decode function
     */
    public function __construct(int $code, string $raw_body, array $headers, array $json_args = [])
    {
        $this->code     = $code;
        $this->headers  = $headers;
        $this->raw_body = $raw_body;
        $this->body     = $raw_body;

        // make sure raw_body is the first argument
        array_unshift($json_args, $raw_body);

        if (function_exists('json_decode')) {
            $json = call_user_func_array('json_decode', $json_args);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->body = $json;
            }
        }
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRawBody(): string
    {
        return $this->raw_body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function convert(ConverterInterface $converter)
    {
        return $converter->createHttpResponse($this);
    }
}
