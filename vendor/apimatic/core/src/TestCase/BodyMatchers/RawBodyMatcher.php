<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

use Core\Types\Sdk\CoreFileWrapper;

class RawBodyMatcher extends BodyMatcher
{
    /**
     * Initializes a RawBodyMatcher object with the expectedBody provided.
     */
    public static function init($expectedBody): self
    {
        $matcher = new self(new BodyComparator(), $expectedBody);
        $matcher->defaultMessage = 'Response body does not match exactly';
        return $matcher;
    }

    /**
     * Asserts if rawBody matches expectedBody.
     */
    public function assert(string $rawBody)
    {
        parent::assert($rawBody);
        if ($this->expectedBody instanceof CoreFileWrapper) {
            $this->expectedBody = $this->expectedBody->getFileContent();
            $this->defaultMessage = 'Binary result does not match the given file';
        }
        $this->testCase->assertEquals($this->expectedBody, $rawBody, $this->defaultMessage);
    }
}
