<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the type of points incentive for a [loyalty promotion]($m/LoyaltyPromotion),
 * which is used to determine how buyers can earn points from the promotion.
 */
class LoyaltyPromotionIncentiveType
{
    /**
     * Multiply the number of points earned from the base loyalty program.
     * For example, "Earn double points."
     */
    public const POINTS_MULTIPLIER = 'POINTS_MULTIPLIER';

    /**
     * Add a specified number of points to those earned from the base loyalty program.
     * For example, "Earn 10 additional points."
     */
    public const POINTS_ADDITION = 'POINTS_ADDITION';
}
