<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether the price of a CatalogItemVariation should be entered manually at the time of sale.
 */
class CatalogPricingType
{
    /**
     * The catalog item variation's price is fixed.
     */
    public const FIXED_PRICING = 'FIXED_PRICING';

    /**
     * The catalog item variation's price is entered at the time of sale.
     */
    public const VARIABLE_PRICING = 'VARIABLE_PRICING';
}
