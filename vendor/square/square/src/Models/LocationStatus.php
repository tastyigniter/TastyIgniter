<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A location's status.
 */
class LocationStatus
{
    /**
     * A location that is active for business.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * A location that is not active for business. Inactive locations provide historical
     * information. Hide inactive locations unless the user has requested to see them.
     */
    public const INACTIVE = 'INACTIVE';
}
