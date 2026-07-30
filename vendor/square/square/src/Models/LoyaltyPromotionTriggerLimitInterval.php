<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the time period that the [trigger limit]($m/LoyaltyPromotionTriggerLimit) applies to,
 * which is used to determine the number of times a buyer can earn points for a [loyalty
 * promotion]($m/LoyaltyPromotion).
 */
class LoyaltyPromotionTriggerLimitInterval
{
    /**
     * The limit applies to the entire time that the promotion is active. For example, if `times`
     * is set to 1 and `time_period` is set to `ALL_TIME`, a buyer can earn promotion points a maximum
     * of one time during the promotion.
     */
    public const ALL_TIME = 'ALL_TIME';

    /**
     * The limit applies per day, according to the `available_time` schedule specified for the promotion.
     * For example, if the `times` field of the trigger limit is set to 1, a buyer can trigger the
     * promotion
     * a maximum of once per day.
     */
    public const DAY = 'DAY';
}
