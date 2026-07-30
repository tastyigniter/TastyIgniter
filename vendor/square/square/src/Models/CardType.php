<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates a card's type, such as `CREDIT` or `DEBIT`.
 */
class CardType
{
    public const UNKNOWN_CARD_TYPE = 'UNKNOWN_CARD_TYPE';

    public const CREDIT = 'CREDIT';

    public const DEBIT = 'DEBIT';
}
