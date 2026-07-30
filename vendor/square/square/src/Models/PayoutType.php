<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of payout: “BATCH” or “SIMPLE”.
 * BATCH payouts include a list of payout entries that can be considered settled.
 * SIMPLE payouts do not have any payout entries associated with them
 * and will show up as one of the payout entries in a future BATCH payout.
 */
class PayoutType
{
    /**
     * Payouts that include a list of payout entries that can be considered settled.
     */
    public const BATCH = 'BATCH';

    /**
     * Payouts that do not have any payout entries associated with them and will
     * show up as one of the payout entries in a future BATCH payout.
     */
    public const SIMPLE = 'SIMPLE';
}
