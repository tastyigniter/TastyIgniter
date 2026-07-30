<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported types of an action as a pending change to a subscription.
 */
class SubscriptionActionType
{
    /**
     * The action to execute a scheduled cancellation of a subscription.
     */
    public const CANCEL = 'CANCEL';

    /**
     * The action to execute a scheduled pause of a subscription.
     */
    public const PAUSE = 'PAUSE';

    /**
     * The action to execute a scheduled resumption of a subscription.
     */
    public const RESUME = 'RESUME';

    /**
     * The action to execute a scheduled swap of a subscription plan in a subscription.
     */
    public const SWAP_PLAN = 'SWAP_PLAN';
}
