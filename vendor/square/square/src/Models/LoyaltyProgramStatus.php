<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether the program is currently active.
 */
class LoyaltyProgramStatus
{
    /**
     * The loyalty program does not have an active subscription.
     * Loyalty API requests fail.
     */
    public const INACTIVE = 'INACTIVE';

    /**
     * The program is fully functional. The program has an active subscription.
     */
    public const ACTIVE = 'ACTIVE';
}
