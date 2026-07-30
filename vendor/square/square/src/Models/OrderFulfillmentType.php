<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The type of fulfillment.
 */
class OrderFulfillmentType
{
    /**
     * A recipient to pick up the fulfillment from a physical [location]($m/Location).
     */
    public const PICKUP = 'PICKUP';

    /**
     * A shipping carrier to ship the fulfillment.
     */
    public const SHIPMENT = 'SHIPMENT';

    /**
     * A courier to deliver the fulfillment.
     */
    public const DELIVERY = 'DELIVERY';
}
