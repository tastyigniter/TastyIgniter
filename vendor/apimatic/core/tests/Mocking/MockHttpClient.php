<?php

namespace Core\Tests\Mocking;

use Core\Tests\Mocking\Response\MockResponse;
use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Response\ResponseInterface;
use CoreInterfaces\Http\HttpClientInterface;

class MockHttpClient implements HttpClientInterface
{
    public function execute(RequestInterface $request): ResponseInterface
    {
        return new MockResponse($request);
    }
}
