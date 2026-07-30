<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates whether Square should alert the merchant when the inventory quantity of a
 * CatalogItemVariation is low.
 */
class InventoryAlertType
{
    /**
     * The variation does not display an alert.
     */
    public const NONE = 'NONE';

    /**
     * The variation generates an alert when its quantity is low.
     */
    public const LOW_QUANTITY = 'LOW_QUANTITY';
}
