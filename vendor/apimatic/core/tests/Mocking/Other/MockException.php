<?php

namespace Core\Tests\Mocking\Other;

use CoreInterfaces\Sdk\ExceptionInterface;
use Core\Tests\Mocking\Types\MockRequest;
use Core\Tests\Mocking\Types\MockCoreResponse;
use Exception;

class MockException extends Exception implements ExceptionInterface
{
    public $request;
    public $response;
    public function __construct(string $reason, MockRequest $request, ?MockCoreResponse $response = null)
    {
        parent::__construct($reason, is_null($response) ? 0 : $response->getStatusCode());
        $this->request = $request;
        $this->response = $response;
    }

    public $additionalProperties = [];

    /**
     * Add a property to this model.
     *
     * @param string $name Name of property
     * @param mixed $value Value of property
     */
    public function addAdditionalProperty(string $name, $value)
    {
        $this->additionalProperties[$name] = $value;
    }
}
