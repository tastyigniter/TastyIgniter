<?php

namespace Mollie\Api\Types;

class SalesInvoiceStatus
{
    /**
     * The sales invoice is in draft status and has not been sent or paid.
     */
    public const DRAFT = 'draft';

    /**
     * The sales invoice has been issued to the customer but has not been paid yet.
     */
    public const ISSUED = 'issued';

    /**
     * The sales invoice has been fully paid.
     */
    public const PAID = 'paid';
}
