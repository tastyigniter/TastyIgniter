<?php

namespace CoreInterfaces\Http;

use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Response\ResponseInterface;

interface HttpClientInterface
{
    /**
     * Sends request and receive response from server.
     *
     * @param RequestInterface $request Request to be sent
     *
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request): ResponseInterface;
}
