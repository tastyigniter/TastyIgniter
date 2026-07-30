<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

class KeysAndValuesBodyMatcher extends KeysBodyMatcher
{
    /**
     * Initializes a new KeysAndValuesBodyMatcher object with the parameters provided.
     */
    public static function init(
        $expectedBody,
        bool $matchArrayOrder = false,
        bool $matchArrayCount = false
    ): KeysBodyMatcher {
        $matcher = new self(new BodyComparator(!$matchArrayCount, $matchArrayOrder, true), $expectedBody);
        $matcher->defaultMessage = 'Response body does not match in keys and/or values';
        return $matcher;
    }
}
