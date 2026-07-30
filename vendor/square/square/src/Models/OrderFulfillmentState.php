<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The current state of this fulfillment.
 */
class OrderFulfillmentState
{
    /**
     * Indicates that the fulfillment has been proposed.
     */
    public const PROPOSED = 'PROPOSED';

    /**
     * Indicates that the fulfillment has been reserved.
     */
    public const RESERVED = 'RESERVED';

    /**
     * Indicates that the fulfillment has been prepared.
     */
    public const PREPARED = 'PREPARED';

    /**
     * Indicates that the fulfillment was successfully completed.
     */
    public const COMPLETED = 'COMPLETED';

    /**
     * Indicates that the fulfillment was canceled.
     */
    public const CANCELED = 'CANCELED';

    /**
     * Indicates that the fulfillment failed to be completed, but was not explicitly
     * canceled.
     */
    public const FAILED = 'FAILED';
}
