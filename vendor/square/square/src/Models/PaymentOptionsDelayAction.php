<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Describes the action to be applied to a delayed capture payment when the delay_duration
 * has elapsed.
 */
class PaymentOptionsDelayAction
{
    /**
     * Indicates that the payment should be automatically canceled when the delay duration
     * elapses.
     */
    public const CANCEL = 'CANCEL';

    /**
     * Indicates that the payment should be automatically completed when the delay duration
     * elapses.
     */
    public const COMPLETE = 'COMPLETE';
}
