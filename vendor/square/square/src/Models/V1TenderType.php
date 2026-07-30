<?php

declare(strict_types=1);

namespace Square\Models;

class V1TenderType
{
    public const CREDIT_CARD = 'CREDIT_CARD';

    public const CASH = 'CASH';

    public const THIRD_PARTY_CARD = 'THIRD_PARTY_CARD';

    public const NO_SALE = 'NO_SALE';

    public const SQUARE_WALLET = 'SQUARE_WALLET';

    public const SQUARE_GIFT_CARD = 'SQUARE_GIFT_CARD';

    public const UNKNOWN = 'UNKNOWN';

    public const OTHER = 'OTHER';
}
