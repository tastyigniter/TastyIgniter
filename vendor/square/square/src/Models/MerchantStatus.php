<?php

declare(strict_types=1);

namespace Square\Models;

class MerchantStatus
{
    /**
     * A fully operational merchant account. The merchant can interact with Square products and APIs.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * A functionally limited merchant account. The merchant can only have limited interaction
     * via Square APIs. The merchant cannot log in or access the seller dashboard.
     */
    public const INACTIVE = 'INACTIVE';
}
