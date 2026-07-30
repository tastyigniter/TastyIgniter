<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Unit of time used to measure a quantity (a duration).
 */
class MeasurementUnitTime
{
    /**
     * The time is measured in milliseconds.
     */
    public const GENERIC_MILLISECOND = 'GENERIC_MILLISECOND';

    /**
     * The time is measured in seconds.
     */
    public const GENERIC_SECOND = 'GENERIC_SECOND';

    /**
     * The time is measured in minutes.
     */
    public const GENERIC_MINUTE = 'GENERIC_MINUTE';

    /**
     * The time is measured in hours.
     */
    public const GENERIC_HOUR = 'GENERIC_HOUR';

    /**
     * The time is measured in days.
     */
    public const GENERIC_DAY = 'GENERIC_DAY';
}
