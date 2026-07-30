<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for adding money to a [gift card]($m/GiftCard).
 */
class GiftCardActivityAdjustIncrementReason
{
    /**
     * The seller gifted a complimentary gift card balance increase.
     */
    public const COMPLIMENTARY = 'COMPLIMENTARY';

    /**
     * The seller increased the gift card balance
     * to accommodate support issues.
     */
    public const SUPPORT_ISSUE = 'SUPPORT_ISSUE';

    /**
     * The transaction is voided.
     */
    public const TRANSACTION_VOIDED = 'TRANSACTION_VOIDED';
}
