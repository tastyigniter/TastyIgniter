<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Specifies the `status` of `Shift` records to be returned.
 */
class ShiftFilterStatus
{
    /**
     * Shifts that have been started and not ended.
     */
    public const OPEN = 'OPEN';

    /**
     * Shifts that have been started and ended.
     */
    public const CLOSED = 'CLOSED';
}
