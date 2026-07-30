<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the state of a tracked item quantity in the lifecycle of goods.
 */
class InventoryState
{
    /**
     * The related quantity of items are in a custom state. **READ-ONLY**:
     * the Inventory API cannot move quantities to or from this state.
     */
    public const CUSTOM = 'CUSTOM';

    /**
     * The related quantity of items are on hand and available for sale.
     */
    public const IN_STOCK = 'IN_STOCK';

    /**
     * The related quantity of items were sold as part of an itemized
     * transaction. Quantities in the `SOLD` state are no longer tracked.
     */
    public const SOLD = 'SOLD';

    /**
     * The related quantity of items were returned through the Square Point
     * of Sale application, but are not yet available for sale. **READ-ONLY**:
     * the Inventory API cannot move quantities to or from this state.
     */
    public const RETURNED_BY_CUSTOMER = 'RETURNED_BY_CUSTOMER';

    /**
     * The related quantity of items are on hand, but not currently
     * available for sale. **READ-ONLY**: the Inventory API cannot move
     * quantities to or from this state.
     */
    public const RESERVED_FOR_SALE = 'RESERVED_FOR_SALE';

    /**
     * The related quantity of items were sold online. **READ-ONLY**: the
     * Inventory API cannot move quantities to or from this state.
     */
    public const SOLD_ONLINE = 'SOLD_ONLINE';

    /**
     * The related quantity of items were ordered from a vendor but not yet
     * received. **READ-ONLY**: the Inventory API cannot move quantities to or
     * from this state.
     */
    public const ORDERED_FROM_VENDOR = 'ORDERED_FROM_VENDOR';

    /**
     * The related quantity of items were received from a vendor but are
     * not yet available for sale. **READ-ONLY**: the Inventory API cannot move
     * quantities to or from this state.
     */
    public const RECEIVED_FROM_VENDOR = 'RECEIVED_FROM_VENDOR';

    /**
     * The related quantity of items are in transit between locations.
     * *READ-ONLY**: the Inventory API cannot move quantities to or from this
     * state.
     */
    public const IN_TRANSIT_TO = 'IN_TRANSIT_TO';

    /**
     * A placeholder indicating that the related quantity of items are not
     * currently tracked in Square. Transferring quantities from the `NONE` state
     * to a tracked state (e.g., `IN_STOCK`) introduces stock into the system.
     */
    public const NONE = 'NONE';

    /**
     * The related quantity of items are lost or damaged and cannot be
     * sold.
     */
    public const WASTE = 'WASTE';

    /**
     * The related quantity of items were returned but not linked to a
     * previous transaction. Unlinked returns are not tracked in Square.
     * Transferring a quantity from `UNLINKED_RETURN` to a tracked state (e.g.,
     * `IN_STOCK`) introduces new stock into the system.
     */
    public const UNLINKED_RETURN = 'UNLINKED_RETURN';

    /**
     * The related quantity of items that are part of a composition consisting one or more components.
     */
    public const COMPOSED = 'COMPOSED';

    /**
     * The related quantity of items that are part of a component.
     */
    public const DECOMPOSED = 'DECOMPOSED';

    /**
     * This state is not supported by this version of the Square API. We recommend that you upgrade the
     * client to use the appropriate version of the Square API supporting this state.
     */
    public const SUPPORTED_BY_NEWER_VERSION = 'SUPPORTED_BY_NEWER_VERSION';
}
