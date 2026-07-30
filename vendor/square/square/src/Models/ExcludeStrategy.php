<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates which products matched by a CatalogPricingRule
 * will be excluded if the pricing rule uses an exclude set.
 */
class ExcludeStrategy
{
    /**
     * The least expensive matched products are excluded from the pricing. If
     * the pricing rule is set to exclude one product and multiple products in the
     * match set qualify as least expensive, then one will be excluded at random.
     *
     * Excluding the least expensive product gives the best discount value to the buyer.
     */
    public const LEAST_EXPENSIVE = 'LEAST_EXPENSIVE';

    /**
     * The most expensive matched product is excluded from the pricing rule.
     * If multiple products have the same price and all qualify as least expensive,
     * one will be excluded at random.
     *
     * This guarantees that the most expensive product is purchased at full price.
     */
    public const MOST_EXPENSIVE = 'MOST_EXPENSIVE';
}
