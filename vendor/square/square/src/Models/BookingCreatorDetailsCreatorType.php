<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported types of a booking creator.
 */
class BookingCreatorDetailsCreatorType
{
    /**
     * The creator is of the seller type.
     */
    public const TEAM_MEMBER = 'TEAM_MEMBER';

    /**
     * The creator is of the buyer type.
     */
    public const CUSTOMER = 'CUSTOMER';
}
