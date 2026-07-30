<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A list of products to return to external callers.
 */
class ApplicationDetailsExternalSquareProduct
{
    public const APPOINTMENTS = 'APPOINTMENTS';

    public const ECOMMERCE_API = 'ECOMMERCE_API';

    public const INVOICES = 'INVOICES';

    public const ONLINE_STORE = 'ONLINE_STORE';

    public const OTHER = 'OTHER';

    public const RESTAURANTS = 'RESTAURANTS';

    public const RETAIL = 'RETAIL';

    public const SQUARE_POS = 'SQUARE_POS';

    public const TERMINAL_API = 'TERMINAL_API';

    public const VIRTUAL_TERMINAL = 'VIRTUAL_TERMINAL';
}
