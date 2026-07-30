<?php

namespace Mollie\Api\Types;

class TerminalStatus
{
    /**
     * The terminal has just been created but not yet active.
     */
    public const STATUS_PENDING = "pending";

    /**
     * The terminal has been activated and can take payments.
     */
    public const STATUS_ACTIVE = "active";

    /**
     * The terminal has been deactivated.
     */
    public const STATUS_INACTIVE = "inactive";
}
