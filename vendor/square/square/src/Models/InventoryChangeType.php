<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates how the inventory change was applied to a tracked product quantity.
 */
class InventoryChangeType
{
    /**
     * The change occurred as part of a physical count update.
     */
    public const PHYSICAL_COUNT = 'PHYSICAL_COUNT';

    /**
     * The change occurred as part of the normal lifecycle of goods
     * (e.g., as an inventory adjustment).
     */
    public const ADJUSTMENT = 'ADJUSTMENT';

    /**
     * The change occurred as part of an inventory transfer.
     */
    public const TRANSFER = 'TRANSFER';
}
