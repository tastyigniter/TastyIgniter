<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Policies for accepting bookings.
 */
class BusinessBookingProfileBookingPolicy
{
    /**
     * The seller accepts all booking requests automatically.
     */
    public const ACCEPT_ALL = 'ACCEPT_ALL';

    /**
     * The seller must accept requests to complete bookings.
     */
    public const REQUIRES_ACCEPTANCE = 'REQUIRES_ACCEPTANCE';
}
