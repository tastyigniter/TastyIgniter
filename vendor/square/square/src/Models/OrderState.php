<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The state of the order.
 */
class OrderState
{
    /**
     * Indicates that the order is open. Open orders can be updated.
     */
    public const OPEN = 'OPEN';

    /**
     * Indicates that the order is completed. Completed orders are fully paid. This is a terminal state.
     */
    public const COMPLETED = 'COMPLETED';

    /**
     * Indicates that the order is canceled. Canceled orders are not paid. This is a terminal state.
     */
    public const CANCELED = 'CANCELED';

    /**
     * Indicates that the order is in a draft state. Draft orders can be updated,
     * but cannot be paid or fulfilled.
     * For more information, see [Create Orders](https://developer.squareup.com/docs/orders-api/create-
     * orders).
     */
    public const DRAFT = 'DRAFT';
}
