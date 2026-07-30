<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates a card's prepaid type, such as `NOT_PREPAID` or `PREPAID`.
 */
class CardPrepaidType
{
    public const UNKNOWN_PREPAID_TYPE = 'UNKNOWN_PREPAID_TYPE';

    public const NOT_PREPAID = 'NOT_PREPAID';

    public const PREPAID = 'PREPAID';
}
