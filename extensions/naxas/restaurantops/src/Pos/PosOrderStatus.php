<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Pos;

final class PosOrderStatus
{
    public const DRAFT = 'draft';

    public const HELD = 'held';

    public const ACTIVE = 'active';

    public const KITCHEN_PENDING = 'kitchen_pending';

    public const PAYMENT_PENDING = 'payment_pending';

    public const PAYMENT_PROCESSING = 'payment_processing';

    public const PAID = 'paid';

    public const PAYMENT_FAILED = 'payment_failed';

    public const PAYMENT_REVERSED = 'payment_reversed';

    public const CANCELLED = 'cancelled';
}
