<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The field to use for sorting.
 */
class InvoiceSortField
{
    /**
     * The field works as follows:
     *
     * - If the invoice is a draft, it uses the invoice `created_at` date.
     * - If the invoice is scheduled for publication, it uses the `scheduled_at` date.
     * - If the invoice is published, it uses the invoice publication date.
     */
    public const INVOICE_SORT_DATE = 'INVOICE_SORT_DATE';
}
