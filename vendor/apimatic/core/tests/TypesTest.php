<?php

namespace Core\Tests;

use Core\Client;
use Core\Request\Request;
use Core\Response\Context;
use Core\Tests\Mocking\MockHelper;
use Core\Tests\Mocking\Other\MockException;
use Core\Tests\Mocking\Types\MockApiResponse;
use Core\Tests\Mocking\Types\MockContext;
use Core\Tests\Mocking\Types\MockCoreResponse;
use Core\Tests\Mocking\Types\MockRequest;
use Core\Utils\CoreHelper;
use CoreInterfaces\Core\Request\RequestMethod;
use PHPUnit\Framework\TestCase;

class TypesTest extends TestCase
{
    public function testChildOfCoreRequest()
    {
        $request = new Request('https://localhost:3000');
        $sdkRequest = $request->convert();

        $this->assertInstanceOf(MockRequest::class, $sdkRequest);
        $sdkRequest->setHttpMethod(RequestMethod::POST);
        $this->assertEquals(RequestMethod::POST, $sdkRequest->getHttpMethod());
        $sdkRequest->setQueryUrl('some/new/path');
        $this->assertEquals('some/new/path', $sdkRequest->getQueryUrl());
        $sdkRequest->setHeaders(['def' => 'def value']);
        $sdkRequest->addHeader('def2', 'def2 value');
        $this->assertEquals(['def' => 'def value', 'def2' => 'def2 value'], $sdkRequest->getHeaders());
        $sdkRequest->setParameters(['def' => 'def value']);
        $this->assertEquals(['def' => 'def value'], $sdkRequest->getParameters());
    }

    public function testChildOfCoreResponse()
    {
        $response = MockHelper::getResponse();
        $sdkResponse = $response->convert(Client::getConverter(MockHelper::getClient()));

        $this->assertInstanceOf(MockCoreResponse::class, $sdkResponse);
        $this->assertEquals(200, $sdkResponse->getStatusCode());
        $this->assertEquals([], $sdkResponse->getHeaders());
        $this->assertEquals('{"res":"This is raw body"}', $sdkResponse->getRawBody());
    }

    public function testChildOfCoreApiResponse()
    {
        $request = new Request('https://localhost:3000');
        $response = MockHelper::getResponse();
        $context = new Context($request, $response, MockHelper::getClient());
        $sdkApiResponse = $context->toApiResponse(["alpha", "beta"]);

        $this->assertInstanceOf(MockApiResponse::class, $sdkApiResponse);
        $this->assertInstanceOf(MockRequest::class, $sdkApiResponse->getRequest());
        $this->assertEquals([], $sdkApiResponse->getHeaders());
        $this->assertEquals(200, $sdkApiResponse->getStatusCode());
        $this->assertEquals('{"res":"This is raw body"}', $sdkApiResponse->getBody());
        $this->assertNull($sdkApiResponse->getReasonPhrase());
        $this->assertEquals(["alpha", "beta"], $sdkApiResponse->getResult());
    }

    public function testCoreExceptionConverterFromContext()
    {
        $request = new Request('https://localhost:3000');
        $response = MockHelper::getResponse();
        $context = new Context($request, $response, MockHelper::getClient());
        $sdkException = $context->toApiException('Error Occurred');

        $this->assertInstanceOf(MockException::class, $sdkException);
        $this->assertEquals('Error Occurred', $sdkException->getMessage());
        $this->assertInstanceOf(MockRequest::class, $sdkException->request);
        $this->assertInstanceOf(MockCoreResponse::class, $sdkException->response);
    }

    public function testCoreExceptionConverterFromRequest()
    {
        $request = new Request('https://localhost:3000');
        $sdkException = $request->toApiException('Error Occurred');

        $this->assertInstanceOf(MockException::class, $sdkException);
        $this->assertEquals('Error Occurred', $sdkException->getMessage());
        $this->assertInstanceOf(MockRequest::class, $sdkException->request);
        $this->assertNull($sdkException->response);
    }

    public function testCallbackCatcher()
    {
        $callback = MockHelper::getCallbackCatcher();
        $request = new Request('https://localhost:3000');
        $this->assertNull($callback->getOnBeforeRequest());
        $callback->callOnBeforeWithConversion($request, Client::getConverter(MockHelper::getClient()));

        $response = MockHelper::getResponse();
        $context = new Context($request, $response, MockHelper::getClient());
        $callback->callOnAfterWithConversion($context, Client::getConverter(MockHelper::getClient()));

        $this->assertEquals($request, $callback->getRequest());
        $this->assertEquals($response, $callback->getResponse());
    }

    public function testChildOfCoreCallback()
    {
        $callback = MockHelper::getCallback();
        $callback->setOnBeforeRequest(function (MockRequest $sdkRequest): void {
            $this->assertInstanceOf(MockRequest::class, $sdkRequest);
            $this->assertEquals(RequestMethod::GET, $sdkRequest->getHttpMethod());
            $this->assertEquals('https://localhost:3000', $sdkRequest->getQueryUrl());
            $this->assertEquals([], $sdkRequest->getHeaders());
            $this->assertEquals([], $sdkRequest->getParameters());
        });
        $callback->setOnAfterRequest(function (MockContext $sdkContext): void {
            $this->assertInstanceOf(MockRequest::class, $sdkContext->getRequest());
            $this->assertInstanceOf(MockCoreResponse::class, $sdkContext->getResponse());
        });

        $request = new Request('https://localhost:3000');
        $response = MockHelper::getResponse();
        $context = new Context($request, $response, MockHelper::getClient());

        $this->assertNotNull($callback->getOnBeforeRequest());
        $this->assertNotNull($callback->getOnAfterRequest());

        $callback->callOnBeforeWithConversion($request, Client::getConverter(MockHelper::getClient()));
        $callback->callOnAfterWithConversion($context, Client::getConverter(MockHelper::getClient()));
    }

    public function testChildOfCoreCallbackWithoutAnyCallback()
    {
        $callback = MockHelper::getCallback();

        $callback->callOnBeforeRequest(null);
        $callback->callOnAfterRequest(null);

        $this->assertNull($callback->getOnBeforeRequest());
        $this->assertNull($callback->getOnAfterRequest());
    }

    public function testChildOfCoreFileWrapper()
    {
        $fileWrapper = MockHelper::getFileWrapper();
        $this->assertEquals('text/plain', $fileWrapper->getMimeType());
        $this->assertEquals('My Text', $fileWrapper->getFilename());
        $this->assertEquals(
            'This test file is created to test CoreFileWrapper functionality',
            CoreHelper::serialize($fileWrapper)
        );
        $curlFile = $fileWrapper->createCurlFileInstance();
        $this->assertStringEndsWith('testFile.txt', $curlFile->getFilename());
        $this->assertEquals('text/plain', $curlFile->getMimeType());
        $this->assertEquals('My Text', $curlFile->getPostFilename());

        $fileWrapper = MockHelper::getFileWrapperFromUrl();
        $this->assertEquals('text/plain', $fileWrapper->getMimeType());
        $this->assertEquals('My Text', $fileWrapper->getFilename());
        $this->assertEquals(
            'This test file is created to test CoreFileWrapper functionality',
            CoreHelper::serialize($fileWrapper)
        );
        $curlFile = $fileWrapper->createCurlFileInstance();
        $this->assertStringEndsWith('tmp', $curlFile->getFilename());
        $this->assertStringContainsString('sdktests', $curlFile->getFilename());
        $this->assertEquals('text/plain', $curlFile->getMimeType());
        $this->assertEquals('My Text', $curlFile->getPostFilename());
    }
}
