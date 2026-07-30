<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported types of location where service is provided.
 */
class BusinessAppointmentSettingsBookingLocationType
{
    /**
     * The service is provided at a seller location.
     */
    public const BUSINESS_LOCATION = 'BUSINESS_LOCATION';

    /**
     * The service is provided at a customer location.
     */
    public const CUSTOMER_LOCATION = 'CUSTOMER_LOCATION';

    /**
     * The service is provided over the phone.
     */
    public const PHONE = 'PHONE';
}
