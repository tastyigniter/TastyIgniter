<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for clearing the balance of a [gift card]($m/GiftCard).
 */
class GiftCardActivityClearBalanceReason
{
    /**
     * The seller suspects suspicious activity.
     */
    public const SUSPICIOUS_ACTIVITY = 'SUSPICIOUS_ACTIVITY';

    /**
     * The seller cleared the balance to reuse the gift card.
     */
    public const REUSE_GIFTCARD = 'REUSE_GIFTCARD';

    /**
     * The gift card balance was cleared for an unknown reason.
     *
     * This reason is read-only and cannot be used to create a `CLEAR_BALANCE` activity using the Gift Card
     * Activities API.
     */
    public const UNKNOWN_REASON = 'UNKNOWN_REASON';
}
