<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments\Contracts;

use Naxas\RestaurantOps\Models\PosPayment;

interface OfficialPaymentAdapter
{
    public function outstanding(int $orderId): string;

    public function synchronize(PosPayment $payment, array $safeSummary): string;

    public function supportsReversal(PosPayment $payment): bool;
}
