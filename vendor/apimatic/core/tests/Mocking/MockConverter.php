<?php

namespace Core\Tests\Mocking;

use Core\Tests\Mocking\Other\MockException;
use Core\Tests\Mocking\Types\MockApiResponse;
use Core\Tests\Mocking\Types\MockContext;
use Core\Tests\Mocking\Types\MockCoreResponse;
use Core\Tests\Mocking\Types\MockFileWrapper;
use Core\Tests\Mocking\Types\MockRequest;
use CoreInterfaces\Core\ContextInterface;
use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Response\ResponseInterface;
use CoreInterfaces\Sdk\ConverterInterface;

class MockConverter implements ConverterInterface
{
    public function createApiException(
        string $message,
        RequestInterface $request,
        ?ResponseInterface $response
    ): MockException {
        $response = $response == null ? null : $this->createHttpResponse($response);
        return new MockException($message, $this->createHttpRequest($request), $response);
    }

    public function createHttpContext(ContextInterface $context): MockContext
    {
        return new MockContext(
            $this->createHttpRequest($context->getRequest()),
            $this->createHttpResponse($context->getResponse())
        );
    }

    public function createHttpRequest(RequestInterface $request): MockRequest
    {
        return new MockRequest(
            $request->getHttpMethod(),
            $request->getHeaders(),
            $request->getQueryUrl(),
            $request->getParameters()
        );
    }

    public function createHttpResponse(ResponseInterface $response): MockCoreResponse
    {
        return new MockCoreResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getRawBody()
        );
    }

    public function createApiResponse(ContextInterface $context, $deserializedBody): MockApiResponse
    {
        $decodedBody = $context->getResponse()->getBody();
        return MockApiResponse::createFromContext($decodedBody, $deserializedBody, $this->createHttpContext($context));
    }

    public function createFileWrapper(string $realFilePath, ?string $mimeType, ?string $filename): MockFileWrapper
    {
        return MockFileWrapper::createFromPath($realFilePath, $mimeType, $filename);
    }
}
