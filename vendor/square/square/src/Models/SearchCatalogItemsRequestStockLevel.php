<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines supported stock levels of the item inventory.
 */
class SearchCatalogItemsRequestStockLevel
{
    /**
     * The item inventory is empty.
     */
    public const OUT = 'OUT';

    /**
     * The item inventory is low.
     */
    public const LOW = 'LOW';
}
