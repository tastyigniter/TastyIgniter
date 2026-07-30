<?php

namespace Mollie\Api\Types;

class InvoiceStatus
{
    /**
     * The invoice is not paid yet.
     */
    public const STATUS_OPEN = "open";

    /**
     * The invoice is paid.
     */
    public const STATUS_PAID = "paid";

    /**
     * Payment of the invoice is overdue.
     */
    public const STATUS_OVERDUE = "overdue";
}
