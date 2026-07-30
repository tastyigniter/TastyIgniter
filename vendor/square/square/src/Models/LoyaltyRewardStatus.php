<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The status of the loyalty reward.
 */
class LoyaltyRewardStatus
{
    /**
     * The reward is issued.
     */
    public const ISSUED = 'ISSUED';

    /**
     * The reward is redeemed.
     */
    public const REDEEMED = 'REDEEMED';

    /**
     * The reward is deleted.
     */
    public const DELETED = 'DELETED';
}
