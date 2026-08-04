<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments\Events;

use Illuminate\Foundation\Events\Dispatchable;

final class PosPaymentFailed
{
    use Dispatchable;

    public function __construct(public readonly array $snapshot) {}
}
