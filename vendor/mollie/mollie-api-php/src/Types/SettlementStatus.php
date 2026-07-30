<?php

namespace Mollie\Api\Types;

class SettlementStatus
{
    /**
     * The settlement has not been closed yet.
     */
    public const STATUS_OPEN = 'open';

    /**
     * The settlement has been closed and is being processed.
     */
    public const STATUS_PENDING = 'pending';

    /**
     * The settlement has been paid out.
     */
    public const STATUS_PAIDOUT = 'paidout';

    /**
     * The settlement could not be paid out.
     */
    public const STATUS_FAILED = 'failed';
}
