<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the status of a [loyalty promotion]($m/LoyaltyPromotion).
 */
class LoyaltyPromotionStatus
{
    /**
     * The loyalty promotion is currently active. Buyers can earn points for purchases
     * that meet the promotion conditions, such as the promotion's `available_time`.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * The loyalty promotion has ended because the specified `end_date` was reached.
     * `ENDED` is a terminal status.
     */
    public const ENDED = 'ENDED';

    /**
     * The loyalty promotion was canceled. `CANCELED` is a terminal status.
     */
    public const CANCELED = 'CANCELED';

    /**
     * The loyalty promotion is scheduled to start in the future. Square changes the
     * promotion status to `ACTIVE` when the `start_date` is reached.
     */
    public const SCHEDULED = 'SCHEDULED';
}
