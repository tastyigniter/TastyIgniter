<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported timings when a pending change, as an action, takes place to a subscription.
 */
class ChangeTiming
{
    /**
     * The action occurs immediately.
     */
    public const IMMEDIATE = 'IMMEDIATE';

    /**
     * The action occurs at the end of the billing cycle.
     */
    public const END_OF_BILLING_CYCLE = 'END_OF_BILLING_CYCLE';
}
