<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A location's type.
 */
class LocationType
{
    /**
     * A place of business with a physical location.
     */
    public const PHYSICAL = 'PHYSICAL';

    /**
     * A place of business that is mobile, such as a food truck or online store.
     */
    public const MOBILE = 'MOBILE';
}
