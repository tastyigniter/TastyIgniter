<?php

declare(strict_types=1);

namespace Core\TestCase;

use PHPUnit\Framework\TestCase;

class HeadersMatcher
{
    private $headers = [];
    private $allowExtra = false;
    private $testCase;
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Set an array of arrays, where inner arrays must be of length 2,
     * i.e. index0 => headerValue, index1 => checkValueBool
     *
     * @param array<string,array> $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Sets allowExtra flag to true.
     */
    public function allowExtra(): void
    {
        $this->allowExtra = true;
    }

    /**
     * Asserts if provided headers match according to the properties set within object.
     */
    public function assert(array $headers)
    {
        if (empty($this->headers)) {
            return;
        }

        // Http headers are case-insensitive
        $expected = array_change_key_case($this->headers);
        $actual = array_change_key_case($headers);
        $message = "Headers do not match";
        if (!$this->allowExtra) {
            $message = "$message strictly";
            $this->testCase->assertCount(count($expected), $actual, $message);
        }

        $actualKeys = array_keys($actual);
        array_walk($expected, function ($valueArray, $key) use ($actual, $actualKeys, $message): void {
            $this->testCase->assertTrue(in_array($key, $actualKeys, true), $message);
            if (!is_bool($valueArray[1])) {
                return;
            }
            if ($valueArray[1]) {
                $this->testCase->assertEquals($valueArray[0], $actual[$key], $message);
            }
        });
    }
}
