<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Enumerates the `Shift` fields to sort on.
 */
class ShiftSortField
{
    /**
     * The start date/time of a `Shift`
     */
    public const START_AT = 'START_AT';

    /**
     * The end date/time of a `Shift`
     */
    public const END_AT = 'END_AT';

    /**
     * The date/time that a `Shift` is created
     */
    public const CREATED_AT = 'CREATED_AT';

    /**
     * The most recent date/time that a `Shift` is updated
     */
    public const UPDATED_AT = 'UPDATED_AT';
}
