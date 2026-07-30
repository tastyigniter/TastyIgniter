<?php

namespace Mollie\Api\Types;

class OrderStatus
{
    /**
     * The order has just been created.
     */
    public const STATUS_CREATED = "created";

    /**
     * The order has been paid.
     */
    public const STATUS_PAID = "paid";

    /**
     * The order has been authorized.
     */
    public const STATUS_AUTHORIZED = "authorized";

    /**
     * The order has been canceled.
     */
    public const STATUS_CANCELED = "canceled";

    /**
     * The order is shipping.
     */
    public const STATUS_SHIPPING = "shipping";

    /**
     * The order is completed.
     */
    public const STATUS_COMPLETED = "completed";

    /**
     * The order is expired.
     */
    public const STATUS_EXPIRED = "expired";

    /**
     * The order is pending.
     */
    public const STATUS_PENDING = "pending";

    /**
     * (Deprecated) The order has been refunded.
     * @deprecated 2018-11-27
     */
    public const STATUS_REFUNDED = "refunded";
}
