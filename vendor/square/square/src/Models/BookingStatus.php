<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Supported booking statuses.
 */
class BookingStatus
{
    /**
     * An unaccepted booking. It is visible to both sellers and customers.
     */
    public const PENDING = 'PENDING';

    /**
     * A customer-cancelled booking. It is visible to both the seller and the customer.
     */
    public const CANCELLED_BY_CUSTOMER = 'CANCELLED_BY_CUSTOMER';

    /**
     * A seller-cancelled booking. It is visible to both the seller and the customer.
     */
    public const CANCELLED_BY_SELLER = 'CANCELLED_BY_SELLER';

    /**
     * A declined booking. It had once been pending, but was then declined by the seller.
     */
    public const DECLINED = 'DECLINED';

    /**
     * An accepted booking agreed to or accepted by the seller.
     */
    public const ACCEPTED = 'ACCEPTED';

    /**
     * A no-show booking. The booking was accepted at one time, but have now been marked as a no-show by
     * the seller because the client either missed the booking or cancelled it without enough notice.
     */
    public const NO_SHOW = 'NO_SHOW';
}
