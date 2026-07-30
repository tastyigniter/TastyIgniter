<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Enumerates the possible status of a `Shift`.
 */
class ShiftStatus
{
    /**
     * Employee started a work shift and the shift is not complete
     */
    public const OPEN = 'OPEN';

    /**
     * Employee started and ended a work shift.
     */
    public const CLOSED = 'CLOSED';
}
