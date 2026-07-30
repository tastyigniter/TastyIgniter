<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether this is a line-item or order-level discount.
 */
class OrderLineItemDiscountScope
{
    /**
     * Used for reporting only.
     * The original transaction discount scope is currently not supported by the API.
     */
    public const OTHER_DISCOUNT_SCOPE = 'OTHER_DISCOUNT_SCOPE';

    /**
     * The discount should be applied to only line items specified by
     * `OrderLineItemAppliedDiscount` reference records.
     */
    public const LINE_ITEM = 'LINE_ITEM';

    /**
     * The discount should be applied to the entire order.
     */
    public const ORDER = 'ORDER';
}
