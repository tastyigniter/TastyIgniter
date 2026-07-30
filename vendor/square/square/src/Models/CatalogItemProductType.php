<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of a CatalogItem. Connect V2 only allows the creation of `REGULAR` or
 * `APPOINTMENTS_SERVICE` items.
 */
class CatalogItemProductType
{
    /**
     * An ordinary item.
     */
    public const REGULAR = 'REGULAR';

    /**
     * A Square gift card.
     */
    public const GIFT_CARD = 'GIFT_CARD';

    /**
     * A service that can be booked using the Square Appointments app.
     */
    public const APPOINTMENTS_SERVICE = 'APPOINTMENTS_SERVICE';
}
