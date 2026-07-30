<?php

declare(strict_types=1);

namespace Square\Models;

class V1TenderEntryMethod
{
    public const MANUAL = 'MANUAL';

    public const SCANNED = 'SCANNED';

    public const SQUARE_CASH = 'SQUARE_CASH';

    public const SQUARE_WALLET = 'SQUARE_WALLET';

    public const SWIPED = 'SWIPED';

    public const WEB_FORM = 'WEB_FORM';

    public const OTHER = 'OTHER';
}
