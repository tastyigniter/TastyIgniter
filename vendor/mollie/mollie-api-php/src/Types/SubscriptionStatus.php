<?php

namespace Mollie\Api\Types;

class SubscriptionStatus
{
    public const STATUS_ACTIVE = "active";
    public const STATUS_PENDING = "pending";   // Waiting for a valid mandate.
    public const STATUS_CANCELED = "canceled";
    public const STATUS_SUSPENDED = "suspended"; // Active, but mandate became invalid.
    public const STATUS_COMPLETED = "completed";
}
