<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The capabilities a location might have.
 */
class LocationCapability
{
    /**
     * The capability to process credit card transactions with Square.
     */
    public const CREDIT_CARD_PROCESSING = 'CREDIT_CARD_PROCESSING';

    /**
     * The capability to receive automatic transfers from Square.
     */
    public const AUTOMATIC_TRANSFERS = 'AUTOMATIC_TRANSFERS';

    /**
     * The capability to process unlinked refunds with Square.
     */
    public const UNLINKED_REFUNDS = 'UNLINKED_REFUNDS';
}
