<?php

declare(strict_types=1);

namespace Square\Models;

class V1OrderHistoryEntryAction
{
    public const ORDER_PLACED = 'ORDER_PLACED';

    public const DECLINED = 'DECLINED';

    public const PAYMENT_RECEIVED = 'PAYMENT_RECEIVED';

    public const CANCELED = 'CANCELED';

    public const COMPLETED = 'COMPLETED';

    public const REFUNDED = 'REFUNDED';

    public const EXPIRED = 'EXPIRED';
}
