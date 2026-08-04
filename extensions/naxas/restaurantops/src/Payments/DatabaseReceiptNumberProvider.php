<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Naxas\RestaurantOps\Models\ReceiptSequence;
use Naxas\RestaurantOps\Payments\Contracts\ReceiptNumberProvider;

final class DatabaseReceiptNumberProvider implements ReceiptNumberProvider
{
    public function next(int $locationId, string $locationCode): string
    {
        $date = now()->toDateString();
        $row = ReceiptSequence::query()->lockForUpdate()->firstOrCreate(['location_id' => $locationId, 'sequence_date' => $date], ['next_value' => 1]);
        $value = $row->next_value;
        $row->forceFill(['next_value' => $value + 1])->save();
        $code = preg_replace('/[^A-Z0-9]/', '', strtoupper($locationCode)) ?: str_pad((string) $locationId, 3, '0', STR_PAD_LEFT);

        return sprintf('RCP-%s-%s-%06d', $code, now()->format('Ymd'), $value);
    }
}
