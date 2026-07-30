<?php

namespace Mollie\Api\Types;

class ProfileStatus
{
    /**
     * The profile has not been verified yet and can only be used to create test payments.
     */
    public const STATUS_UNVERIFIED = 'unverified';

    /**
     * The profile has been verified and can be used to create live payments and test payments.
     */
    public const STATUS_VERIFIED = 'verified';

    /**
     * The profile is blocked and can thus no longer be used or changed.
     */
    public const STATUS_BLOCKED = 'blocked';
}
