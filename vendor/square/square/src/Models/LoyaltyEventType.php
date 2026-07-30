<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of the loyalty event.
 */
class LoyaltyEventType
{
    /**
     * Points are added to a loyalty account for a purchase that
     * qualified for points based on an [accrual rule]($m/LoyaltyProgramAccrualRule).
     */
    public const ACCUMULATE_POINTS = 'ACCUMULATE_POINTS';

    /**
     * A [loyalty reward]($m/LoyaltyReward) is created.
     */
    public const CREATE_REWARD = 'CREATE_REWARD';

    /**
     * A loyalty reward is redeemed.
     */
    public const REDEEM_REWARD = 'REDEEM_REWARD';

    /**
     * A loyalty reward is deleted.
     */
    public const DELETE_REWARD = 'DELETE_REWARD';

    /**
     * Loyalty points are manually adjusted.
     */
    public const ADJUST_POINTS = 'ADJUST_POINTS';

    /**
     * Loyalty points are expired according to the
     * expiration policy of the loyalty program.
     */
    public const EXPIRE_POINTS = 'EXPIRE_POINTS';

    /**
     * Some other loyalty event occurred.
     */
    public const OTHER = 'OTHER';

    /**
     * Points are added to a loyalty account for a purchase that
     * qualified for a [loyalty promotion]($m/LoyaltyPromotion).
     */
    public const ACCUMULATE_PROMOTION_POINTS = 'ACCUMULATE_PROMOTION_POINTS';
}
