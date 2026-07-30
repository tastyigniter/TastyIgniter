<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The status of the [Vendor]($m/Vendor),
 * whether a [Vendor]($m/Vendor) is active or inactive.
 */
class VendorStatus
{
    /**
     * Vendor is active and can receive purchase orders.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * Vendor is inactive and cannot receive purchase orders.
     */
    public const INACTIVE = 'INACTIVE';
}
