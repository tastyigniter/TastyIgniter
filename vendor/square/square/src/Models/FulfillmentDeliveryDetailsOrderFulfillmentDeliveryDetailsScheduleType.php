<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The schedule type of the delivery fulfillment.
 */
class FulfillmentDeliveryDetailsOrderFulfillmentDeliveryDetailsScheduleType
{
    /**
     * Indicates the fulfillment to deliver at a scheduled deliver time.
     */
    public const SCHEDULED = 'SCHEDULED';

    /**
     * Indicates that the fulfillment to deliver as soon as possible and should be prepared
     * immediately.
     */
    public const ASAP = 'ASAP';
}
