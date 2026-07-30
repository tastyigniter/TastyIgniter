<?php

declare(strict_types=1);

namespace Square\Models;

class V1OrderState
{
    public const PENDING = 'PENDING';

    public const OPEN = 'OPEN';

    public const COMPLETED = 'COMPLETED';

    public const CANCELED = 'CANCELED';

    public const REFUNDED = 'REFUNDED';

    public const REJECTED = 'REJECTED';
}
