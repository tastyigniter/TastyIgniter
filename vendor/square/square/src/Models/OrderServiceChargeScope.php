<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether this is a line-item or order-level apportioned
 * service charge.
 */
class OrderServiceChargeScope
{
    /**
     * Used for reporting only.
     * The original transaction service charge scope is currently not supported by the API.
     */
    public const OTHER_SERVICE_CHARGE_SCOPE = 'OTHER_SERVICE_CHARGE_SCOPE';

    /**
     * The service charge should be applied to only line items specified by
     * `OrderLineItemAppliedServiceCharge` reference records.
     */
    public const LINE_ITEM = 'LINE_ITEM';

    /**
     * The service charge should be applied to the entire order.
     */
    public const ORDER = 'ORDER';
}
