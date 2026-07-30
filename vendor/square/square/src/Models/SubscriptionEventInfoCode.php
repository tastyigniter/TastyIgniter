<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported info codes of a subscription event.
 */
class SubscriptionEventInfoCode
{
    /**
     * The location is not active.
     */
    public const LOCATION_NOT_ACTIVE = 'LOCATION_NOT_ACTIVE';

    /**
     * The location cannot accept payments.
     */
    public const LOCATION_CANNOT_ACCEPT_PAYMENT = 'LOCATION_CANNOT_ACCEPT_PAYMENT';

    /**
     * The subscribing customer profile has been deleted.
     */
    public const CUSTOMER_DELETED = 'CUSTOMER_DELETED';

    /**
     * The subscribing customer does not have an email.
     */
    public const CUSTOMER_NO_EMAIL = 'CUSTOMER_NO_EMAIL';

    /**
     * The subscribing customer does not have a name.
     */
    public const CUSTOMER_NO_NAME = 'CUSTOMER_NO_NAME';

    /**
     * User-provided detail.
     */
    public const USER_PROVIDED = 'USER_PROVIDED';
}
