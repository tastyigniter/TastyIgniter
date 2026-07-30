<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

class NativeBodyMatcher extends BodyMatcher
{
    /**
     * Initializes a new NativeBodyMatcher object with the parameters provided.
     */
    public static function init($expectedBody, bool $matchArrayOrder = false, bool $matchArrayCount = false): self
    {
        $matcher = new self(new BodyComparator(!$matchArrayCount, $matchArrayOrder, true, true), $expectedBody);
        if (is_scalar($expectedBody)) {
            $matcher->defaultMessage = 'Response values does not match';
            return $matcher;
        }
        $type = getType($expectedBody);
        $strategy = self::getMatchingStrategy($matchArrayOrder, $matchArrayCount);
        $matcher->defaultMessage = "Response $type values does not match$strategy";
        return $matcher;
    }

    private static function getMatchingStrategy(bool $matchArrayOrder, bool $matchArrayCount): string
    {
        if (!$matchArrayOrder) {
            if (!$matchArrayCount) {
                return '';
            }
            return ' in size';
        }
        if (!$matchArrayCount) {
            return ' in order';
        }
        return ' in order or size';
    }

    /**
     * Asserts if rawBody matches the criteria set within NativeBodyMatcher while initialization,
     * and if expectedBody is a subset of rawBody.
     */
    public function assert(string $rawBody)
    {
        parent::assert($rawBody);
        $this->testCase->assertTrue(
            $this->bodyComparator->compare($this->expectedBody, $this->result),
            $this->defaultMessage
        );
    }
}
