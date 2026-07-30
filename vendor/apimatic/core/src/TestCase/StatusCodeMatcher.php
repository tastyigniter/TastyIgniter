<?php

declare(strict_types=1);

namespace Core\TestCase;

use PHPUnit\Framework\TestCase;

class StatusCodeMatcher
{
    /**
     * @var int|null
     */
    private $statusCode;

    /**
     * @var int|null
     */
    private $lowerStatusCode;

    /**
     * @var int|null
     */
    private $upperStatusCode;
    private $assertStatusRange = false;
    private $testCase;

    /**
     * Creates a new StatusCodeMatcher object.
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Sets statusCode of the object to the value provided.
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Sets an expected status code range. Used in case the test case expects a status from a range of status codes.
     */
    public function setStatusRange(int $lowerStatusCode, int $upperStatusCode): void
    {
        $this->assertStatusRange = true;
        $this->lowerStatusCode = $lowerStatusCode;
        $this->upperStatusCode = $upperStatusCode;
    }

    /**
     * Assert required assertions according to the properties set within the object.
     */
    public function assert(int $statusCode)
    {
        if (isset($this->statusCode)) {
            $this->testCase->assertEquals($this->statusCode, $statusCode, "Status is not $this->statusCode");
            return;
        }
        if (!$this->assertStatusRange) {
            return;
        }
        $message = "Status is not between $this->lowerStatusCode and $this->upperStatusCode";
        $this->testCase->assertGreaterThanOrEqual($this->lowerStatusCode, $statusCode, $message);
        $this->testCase->assertLessThanOrEqual($this->upperStatusCode, $statusCode, $message);
    }
}
