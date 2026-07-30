<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the Square product used to generate a change.
 */
class Product
{
    /**
     * Square Point of Sale application.
     */
    public const SQUARE_POS = 'SQUARE_POS';

    /**
     * Square Connect APIs (for example, Orders API or Checkout API).
     */
    public const EXTERNAL_API = 'EXTERNAL_API';

    /**
     * A Square subscription (various products).
     */
    public const BILLING = 'BILLING';

    /**
     * Square Appointments.
     */
    public const APPOINTMENTS = 'APPOINTMENTS';

    /**
     * Square Invoices.
     */
    public const INVOICES = 'INVOICES';

    /**
     * Square Online Store.
     */
    public const ONLINE_STORE = 'ONLINE_STORE';

    /**
     * Square Payroll.
     */
    public const PAYROLL = 'PAYROLL';

    /**
     * Square Dashboard.
     */
    public const DASHBOARD = 'DASHBOARD';

    /**
     * Item Library Import.
     */
    public const ITEM_LIBRARY_IMPORT = 'ITEM_LIBRARY_IMPORT';

    /**
     * A Square product that does not match any other value.
     */
    public const OTHER = 'OTHER';
}
