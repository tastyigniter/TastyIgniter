<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The schedule type of the pickup fulfillment.
 */
class FulfillmentPickupDetailsScheduleType
{
    /**
     * Indicates that the fulfillment will be picked up at a scheduled pickup time.
     */
    public const SCHEDULED = 'SCHEDULED';

    /**
     * Indicates that the fulfillment will be picked up as soon as possible and
     * should be prepared immediately.
     */
    public const ASAP = 'ASAP';
}
