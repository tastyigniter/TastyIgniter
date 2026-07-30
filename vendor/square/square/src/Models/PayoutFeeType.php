<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents the type of payout fee that can incur as part of a payout.
 */
class PayoutFeeType
{
    /**
     * Fee type associated with transfers.
     */
    public const TRANSFER_FEE = 'TRANSFER_FEE';

    /**
     * Taxes associated with the transfer fee.
     */
    public const TAX_ON_TRANSFER_FEE = 'TAX_ON_TRANSFER_FEE';
}
