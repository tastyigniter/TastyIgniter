<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates a refund's current status.
 */
class RefundStatus
{
    /**
     * The refund is pending.
     */
    public const PENDING = 'PENDING';

    /**
     * The refund has been approved by Square.
     */
    public const APPROVED = 'APPROVED';

    /**
     * The refund has been rejected by Square.
     */
    public const REJECTED = 'REJECTED';

    /**
     * The refund failed.
     */
    public const FAILED = 'FAILED';
}
