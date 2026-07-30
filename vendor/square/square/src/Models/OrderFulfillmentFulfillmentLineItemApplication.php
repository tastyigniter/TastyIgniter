<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The `line_item_application` describes what order line items this fulfillment applies
 * to. It can be `ALL` or `ENTRY_LIST` with a supplied list of fulfillment entries.
 */
class OrderFulfillmentFulfillmentLineItemApplication
{
    /**
     * If `ALL`, `entries` must be unset.
     */
    public const ALL = 'ALL';

    /**
     * If `ENTRY_LIST`, supply a list of `entries`.
     */
    public const ENTRY_LIST = 'ENTRY_LIST';
}
