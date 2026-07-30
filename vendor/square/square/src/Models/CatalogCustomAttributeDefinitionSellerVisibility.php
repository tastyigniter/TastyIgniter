<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the visibility of a custom attribute to sellers in Square
 * client applications, Square APIs or in Square UIs (including Square Point
 * of Sale applications and Square Dashboard).
 */
class CatalogCustomAttributeDefinitionSellerVisibility
{
    /**
     * Sellers cannot read this custom attribute in Square client
     * applications or Square APIs.
     */
    public const SELLER_VISIBILITY_HIDDEN = 'SELLER_VISIBILITY_HIDDEN';

    /**
     * Sellers can read and write this custom attribute value in catalog objects,
     * but cannot edit the custom attribute definition.
     */
    public const SELLER_VISIBILITY_READ_WRITE_VALUES = 'SELLER_VISIBILITY_READ_WRITE_VALUES';
}
