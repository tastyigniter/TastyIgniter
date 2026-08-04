<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;

final class Money
{
    public static function minor(string|int|float $value): int
    {
        $value = trim((string) $value);
        if (! preg_match('/^\d+(?:\.\d{1,4})?$/', $value)) {
            throw new PaymentException('payment_amount_invalid', 'Amounts must be positive decimals with at most four decimal places.');
        } [$whole,$fraction] = array_pad(explode('.', $value, 2), 2, '');

        return ((int) $whole * 10000) + (int) str_pad($fraction, 4, '0');
    }

    public static function decimal(int $minor): string
    {
        return sprintf('%d.%04d', intdiv($minor, 10000), abs($minor % 10000));
    }
}
