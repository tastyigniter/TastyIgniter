<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported types of an event occurred to a subscription.
 */
class SubscriptionEventSubscriptionEventType
{
    /**
     * The subscription was started.
     */
    public const START_SUBSCRIPTION = 'START_SUBSCRIPTION';

    /**
     * The subscription plan was changed.
     */
    public const PLAN_CHANGE = 'PLAN_CHANGE';

    /**
     * The subscription was stopped.
     */
    public const STOP_SUBSCRIPTION = 'STOP_SUBSCRIPTION';

    /**
     * The subscription was deactivated
     */
    public const DEACTIVATE_SUBSCRIPTION = 'DEACTIVATE_SUBSCRIPTION';

    /**
     * The subscription was resumed.
     */
    public const RESUME_SUBSCRIPTION = 'RESUME_SUBSCRIPTION';

    /**
     * The subscription was paused.
     */
    public const PAUSE_SUBSCRIPTION = 'PAUSE_SUBSCRIPTION';
}
