<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for deducting money from a [gift card]($m/GiftCard).
 */
class GiftCardActivityAdjustDecrementReason
{
    /**
     * The balance was decreased because the seller detected suspicious or fraudulent activity
     * on the gift card.
     */
    public const SUSPICIOUS_ACTIVITY = 'SUSPICIOUS_ACTIVITY';

    /**
     * The balance was decreased to reverse an unintentional balance increase.
     */
    public const BALANCE_ACCIDENTALLY_INCREASED = 'BALANCE_ACCIDENTALLY_INCREASED';

    /**
     * The balance was decreased to accommodate support issues.
     */
    public const SUPPORT_ISSUE = 'SUPPORT_ISSUE';

    /**
     * The balance was decreased because the order used to purchase or reload the
     * gift card was refunded.
     */
    public const PURCHASE_WAS_REFUNDED = 'PURCHASE_WAS_REFUNDED';
}
