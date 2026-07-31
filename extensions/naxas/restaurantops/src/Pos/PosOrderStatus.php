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

    public const CANCELLED = 'cancelled';
}
