<?php

declare(strict_types=1);

namespace Square\Models;

class ActionCancelReason
{
    /**
     * A person canceled the `TerminalCheckout` from a Square device.
     */
    public const BUYER_CANCELED = 'BUYER_CANCELED';

    /**
     * A client canceled the `TerminalCheckout` using the API.
     */
    public const SELLER_CANCELED = 'SELLER_CANCELED';

    /**
     * The `TerminalCheckout` timed out (see `deadline_duration` on the `TerminalCheckout`).
     */
    public const TIMED_OUT = 'TIMED_OUT';
}
