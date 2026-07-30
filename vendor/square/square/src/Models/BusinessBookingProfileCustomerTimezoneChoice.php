<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Choices of customer-facing time zone used for bookings.
 */
class BusinessBookingProfileCustomerTimezoneChoice
{
    /**
     * Use the time zone of the business location for bookings.
     */
    public const BUSINESS_LOCATION_TIMEZONE = 'BUSINESS_LOCATION_TIMEZONE';

    /**
     * Use the customer-chosen time zone for bookings.
     */
    public const CUSTOMER_CHOICE = 'CUSTOMER_CHOICE';
}
