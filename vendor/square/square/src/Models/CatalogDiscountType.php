<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * How to apply a CatalogDiscount to a CatalogItem.
 */
class CatalogDiscountType
{
    /**
     * Apply the discount as a fixed percentage (e.g., 5%) off the item price.
     */
    public const FIXED_PERCENTAGE = 'FIXED_PERCENTAGE';

    /**
     * Apply the discount as a fixed amount (e.g., $1.00) off the item price.
     */
    public const FIXED_AMOUNT = 'FIXED_AMOUNT';

    /**
     * Apply the discount as a variable percentage off the item price. The percentage will be specified at
     * the time of sale.
     */
    public const VARIABLE_PERCENTAGE = 'VARIABLE_PERCENTAGE';

    /**
     * Apply the discount as a variable amount off the item price. The amount will be specified at the time
     * of sale.
     */
    public const VARIABLE_AMOUNT = 'VARIABLE_AMOUNT';
}
