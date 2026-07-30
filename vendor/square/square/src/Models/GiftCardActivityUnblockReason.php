<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for unblocking a [gift card]($m/GiftCard).
 */
class GiftCardActivityUnblockReason
{
    /**
     * The gift card is unblocked because a chargeback was ruled in favor of the seller.
     */
    public const CHARGEBACK_UNBLOCK = 'CHARGEBACK_UNBLOCK';
}
