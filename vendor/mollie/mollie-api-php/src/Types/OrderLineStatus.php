<?php

namespace Mollie\Api\Types;

class OrderLineStatus
{
    /**
     * The order line has just been created.
     */
    public const STATUS_CREATED = "created";

    /**
     * The order line has been paid.
     */
    public const STATUS_PAID = "paid";

    /**
     * The order line has been authorized.
     */
    public const STATUS_AUTHORIZED = "authorized";

    /**
     * The order line has been canceled.
     */
    public const STATUS_CANCELED = "canceled";

    /**
     * (Deprecated) The order line has been refunded.
     * @deprecated
     */
    public const STATUS_REFUNDED = "refunded";

    /**
     * The order line is shipping.
     */
    public const STATUS_SHIPPING = "shipping";

    /**
     * The order line is completed.
     */
    public const STATUS_COMPLETED = "completed";
}
