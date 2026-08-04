<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments\Contracts;

interface ReceiptNumberProvider
{
    public function next(int $locationId, string $locationCode): string;
}
