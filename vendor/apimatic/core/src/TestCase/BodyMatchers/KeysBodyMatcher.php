<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

use Core\Utils\CoreHelper;

class KeysBodyMatcher extends BodyMatcher
{
    /**
     * Initializes a new KeysBodyMatcher object with the parameters provided.
     */
    public static function init($expectedBody, bool $matchArrayOrder = false, bool $matchArrayCount = false): self
    {
        $matcher = new self(new BodyComparator(!$matchArrayCount, $matchArrayOrder, false), $expectedBody);
        $matcher->defaultMessage = 'Response body does not match in keys';
        return $matcher;
    }

    /**
     * Compares rawBody with expectedBody and asserts if expectedBody is a subset of rawBody or not.
     */
    public function assert(string $rawBody)
    {
        parent::assert($rawBody);
        $this->testCase->assertTrue(
            $this->bodyComparator->compare($this->expectedBody, CoreHelper::deserialize($rawBody)),
            $this->defaultMessage
        );
    }
}
