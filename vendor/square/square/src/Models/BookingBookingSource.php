<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported sources a booking was created from.
 */
class BookingBookingSource
{
    /**
     * The booking was created by a seller from a Square Appointments application, such as the Square
     * Appointments Dashboard or a Square Appointments mobile app.
     */
    public const FIRST_PARTY_MERCHANT = 'FIRST_PARTY_MERCHANT';

    /**
     * The booking was created by a buyer from a Square Appointments application, such as Square Online
     * Booking Site.
     */
    public const FIRST_PARTY_BUYER = 'FIRST_PARTY_BUYER';

    /**
     * The booking was created by a buyer created from a third-party application.
     */
    public const THIRD_PARTY_BUYER = 'THIRD_PARTY_BUYER';

    /**
     * The booking was created by a seller or a buyer from the Square Bookings API.
     */
    public const API = 'API';
}
