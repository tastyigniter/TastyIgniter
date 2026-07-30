<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * List of possible destinations against which a payout can be made.
 */
class DestinationType
{
    /**
     * An external bank account outside of Square.
     */
    public const BANK_ACCOUNT = 'BANK_ACCOUNT';

    /**
     * An external card outside of Square used for the transfer.
     */
    public const CARD = 'CARD';

    public const SQUARE_BALANCE = 'SQUARE_BALANCE';

    /**
     * Square Checking or Savings account (US), Square Card (CA)
     */
    public const SQUARE_STORED_BALANCE = 'SQUARE_STORED_BALANCE';
}
