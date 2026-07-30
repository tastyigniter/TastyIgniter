<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the Square product used to process a transaction.
 */
class TransactionProduct
{
    /**
     * Square Point of Sale.
     */
    public const REGISTER = 'REGISTER';

    /**
     * The Square Connect API.
     */
    public const EXTERNAL_API = 'EXTERNAL_API';

    /**
     * A Square subscription for one of multiple products.
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
     * A Square product that does not match any other value.
     */
    public const OTHER = 'OTHER';
}
