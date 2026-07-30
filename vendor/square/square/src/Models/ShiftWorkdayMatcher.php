<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the logic used to apply a workday filter.
 */
class ShiftWorkdayMatcher
{
    /**
     * All shifts that start on or after the specified workday
     */
    public const START_AT = 'START_AT';

    /**
     * All shifts that end on or before the specified workday
     */
    public const END_AT = 'END_AT';

    /**
     * All shifts that start between the start and end workdays (inclusive)
     */
    public const INTERSECTION = 'INTERSECTION';
}
