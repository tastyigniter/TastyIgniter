<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

use PHPUnit\Framework\TestCase;

class BodyMatcher
{
    protected $expectedBody;
    protected $bodyComparator;
    protected $defaultMessage = '';
    /**
     * @var TestCase
     */
    public $testCase;
    public $result;
    public $shouldAssert = true;

    /**
     * Initializes a new BodyMatcher with the parameters provided.
     */
    public function __construct(BodyComparator $bodyComparator, $expectedBody = null)
    {
        $this->bodyComparator = $bodyComparator;
        $this->expectedBody = $expectedBody;
    }

    /**
     * Returns already set default message.
     */
    public function getDefaultMessage(): string
    {
        return $this->defaultMessage;
    }

    /**
     * Sets testCase and result to the ones provided.
     */
    public function set(TestCase $testCase, $result)
    {
        $this->testCase = $testCase;
        $this->result = $result;
    }

    /**
     * Asserts if the testCase results to true or not.
     */
    public function assert(string $rawBody)
    {
        if ($this->shouldAssert) {
            $this->testCase->assertNotNull($this->result, 'Result does not exist');
        }
    }
}
