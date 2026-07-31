<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Pos\Events;

use Illuminate\Foundation\Events\Dispatchable;

final class PosOrderReadyForKitchen
{
    use Dispatchable;

    public function __construct(public readonly array $payload) {}
}
