<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the reason for blocking a [gift card]($m/GiftCard).
 */
class GiftCardActivityBlockReason
{
    /**
     * The gift card is blocked because the buyer initiated a chargeback on the gift card purchase.
     */
    public const CHARGEBACK_BLOCK = 'CHARGEBACK_BLOCK';
}
