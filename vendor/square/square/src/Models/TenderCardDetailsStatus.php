<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the card transaction's current status.
 */
class TenderCardDetailsStatus
{
    /**
     * The card transaction has been authorized but not yet captured.
     */
    public const AUTHORIZED = 'AUTHORIZED';

    /**
     * The card transaction was authorized and subsequently captured (i.e., completed).
     */
    public const CAPTURED = 'CAPTURED';

    /**
     * The card transaction was authorized and subsequently voided (i.e., canceled).
     */
    public const VOIDED = 'VOIDED';

    /**
     * The card transaction failed.
     */
    public const FAILED = 'FAILED';
}
