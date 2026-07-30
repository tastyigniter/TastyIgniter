<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Payout status types
 */
class PayoutStatus
{
    /**
     * Indicates that the payout was successfully sent to the banking destination.
     */
    public const SENT = 'SENT';

    /**
     * Indicates that the payout was rejected by the banking destination.
     */
    public const FAILED = 'FAILED';

    /**
     * Indicates that the payout has successfully completed.
     */
    public const PAID = 'PAID';
}
