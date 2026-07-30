<?php

declare(strict_types=1);

namespace Core\Tests\Mocking\Types;

use Core\Types\Sdk\CoreApiResponse;

class MockApiResponse extends CoreApiResponse
{
    /**
     * Create a new instance of this class with the given context and result.
     *
     * @param mixed $decodedBody Deserialized result from the response
     * @param mixed $result      Deserialized result from the response
     * @param MockContext $context Http context
     */
    public static function createFromContext($decodedBody, $result, MockContext $context): self
    {
        $request = $context->getRequest();
        $statusCode = $context->getResponse()->getStatusCode();
        $reasonPhrase = null;
        $headers = $context->getResponse()->getHeaders();
        $body = $context->getResponse()->getRawBody();

        return new self($request, $statusCode, $reasonPhrase, $headers, $result, $body);
    }

    public function getRequest(): MockRequest
    {
        return $this->request;
    }
}
