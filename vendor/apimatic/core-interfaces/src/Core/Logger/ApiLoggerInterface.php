<?php

namespace CoreInterfaces\Core\Logger;

use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Response\ResponseInterface;

interface ApiLoggerInterface
{
    /**
     * Log the provided request.
     *
     * @param $request RequestInterface HTTP requests to be logged.
     */
    public function logRequest(RequestInterface $request): void;

    /**
     * Log the provided response.
     *
     * @param $response ResponseInterface HTTP responses to be logged.
     */
    public function logResponse(ResponseInterface $response): void;
}