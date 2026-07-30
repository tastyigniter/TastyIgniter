<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for deactivating a [gift card]($m/GiftCard).
 */
class GiftCardActivityDeactivateReason
{
    /**
     * The seller suspects suspicious activity.
     */
    public const SUSPICIOUS_ACTIVITY = 'SUSPICIOUS_ACTIVITY';

    /**
     * The gift card was deactivated for an unknown reason.
     *
     * This reason is read-only and cannot be used to create a `DEACTIVATE` activity using the Gift Card
     * Activities API.
     */
    public const UNKNOWN_REASON = 'UNKNOWN_REASON';

    /**
     * A chargeback on the gift card purchase (or the gift card load) was ruled in favor of the buyer.
     *
     * This reason is read-only and cannot be used to create a `DEACTIVATE` activity using the Gift Card
     * Activities API.
     */
    public const CHARGEBACK_DEACTIVATE = 'CHARGEBACK_DEACTIVATE';
}
