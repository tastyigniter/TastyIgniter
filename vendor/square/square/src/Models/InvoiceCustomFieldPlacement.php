<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates where to render a custom field on the Square-hosted invoice page and in emailed or PDF
 * copies of the invoice.
 */
class InvoiceCustomFieldPlacement
{
    /**
     * Render the custom field above the invoice line items.
     */
    public const ABOVE_LINE_ITEMS = 'ABOVE_LINE_ITEMS';

    /**
     * Render the custom field below the invoice line items.
     */
    public const BELOW_LINE_ITEMS = 'BELOW_LINE_ITEMS';
}
