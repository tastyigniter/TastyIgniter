<?php

declare(strict_types=1);

namespace Core\TestCase;

use Core\TestCase\BodyMatchers\BodyComparator;
use Core\TestCase\BodyMatchers\BodyMatcher;
use Core\Types\CallbackCatcher;
use PHPUnit\Framework\TestCase;

class CoreTestCase
{
    private $callback;
    private $statusCodeMatcher;
    private $headersMatcher;
    private $bodyMatcher;

    /**
     * Initializes a new CoreTestCase object with the parameters provided.
     */
    public function __construct(TestCase $testCase, CallbackCatcher $callbackCatcher, $result)
    {
        $this->callback = $callbackCatcher;
        $this->statusCodeMatcher = new StatusCodeMatcher($testCase);
        $this->headersMatcher = new HeadersMatcher($testCase);
        $this->bodyMatcher = new BodyMatcher(new BodyComparator());
        $this->bodyMatcher->shouldAssert = false;
        $this->bodyMatcher->set($testCase, $result);
    }

    /**
     * Sets the expected status value for the test case.
     */
    public function expectStatus(int $statusCode): self
    {
        $this->statusCodeMatcher->setStatusCode($statusCode);
        return $this;
    }

    /**
     * Sets expected status range in case expected statuses are within a certain range.
     */
    public function expectStatusRange(int $lowerStatusCode, int $upperStatusCode): self
    {
        $this->statusCodeMatcher->setStatusRange($lowerStatusCode, $upperStatusCode);
        return $this;
    }

    /**
     * Sets headers expected from the response within a test case.
     */
    public function expectHeaders(array $headers): self
    {
        $this->headersMatcher->setHeaders($headers);
        return $this;
    }

    /**
     * Sets allowExtra flag to true, which allows headers other than the one specified to be present
     * within the response.
     */
    public function allowExtraHeaders(): self
    {
        $this->headersMatcher->allowExtra();
        return $this;
    }

    /**
     * Sets bodyMatcher of the object to the one provided.
     */
    public function bodyMatcher(BodyMatcher $bodyMatcher): self
    {
        $bodyMatcher->set($this->bodyMatcher->testCase, $this->bodyMatcher->result);
        $this->bodyMatcher = $bodyMatcher;
        return $this;
    }

    /**
     * Calls assert on statusCodeMatcher, headersMatcher and bodyMatcher set within the object.
     */
    public function assert()
    {
        $response = $this->callback->getResponse();
        $this->statusCodeMatcher->assert($response->getStatusCode());
        $this->headersMatcher->assert($response->getHeaders());
        $this->bodyMatcher->assert($response->getRawBody());
    }
}
