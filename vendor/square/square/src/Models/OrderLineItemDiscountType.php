<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates how the discount is applied to the associated line item or order.
 */
class OrderLineItemDiscountType
{
    /**
     * Used for reporting only.
     * The original transaction discount type is currently not supported by the API.
     */
    public const UNKNOWN_DISCOUNT = 'UNKNOWN_DISCOUNT';

    /**
     * Apply the discount as a fixed percentage (such as 5%) off the item price.
     */
    public const FIXED_PERCENTAGE = 'FIXED_PERCENTAGE';

    /**
     * Apply the discount as a fixed monetary value (such as $1.00) off the item price.
     */
    public const FIXED_AMOUNT = 'FIXED_AMOUNT';

    /**
     * Apply the discount as a variable percentage based on the item
     * price.
     *
     * The specific discount percentage of a `VARIABLE_PERCENTAGE` discount
     * is assigned at the time of the purchase.
     */
    public const VARIABLE_PERCENTAGE = 'VARIABLE_PERCENTAGE';

    /**
     * Apply the discount as a variable amount based on the item price.
     *
     * The specific discount amount of a `VARIABLE_AMOUNT` discount
     * is assigned at the time of the purchase.
     */
    public const VARIABLE_AMOUNT = 'VARIABLE_AMOUNT';
}
