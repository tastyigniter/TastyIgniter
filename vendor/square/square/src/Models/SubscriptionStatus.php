<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported subscription statuses.
 */
class SubscriptionStatus
{
    /**
     * The subscription is pending to start in the future.
     */
    public const PENDING = 'PENDING';

    /**
     * The subscription is active.
     */
    public const ACTIVE = 'ACTIVE';

    /**
     * The subscription is canceled.
     */
    public const CANCELED = 'CANCELED';

    /**
     * The subscription is deactivated.
     */
    public const DEACTIVATED = 'DEACTIVATED';

    /**
     * The subscription is paused.
     */
    public const PAUSED = 'PAUSED';
}
