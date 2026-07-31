<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class Money
{
    public static function normalize(int|string $value, bool $positive = false): string
    {
        $value = trim((string) $value);
        if (! preg_match('/^-?\d+(?:\.\d{1,4})?$/', $value)) {
            throw new ShiftException('shift_money_invalid', 'Money must be a decimal value with at most four decimal places.');
        }

        $scaled = self::toScaled($value);
        if ($positive && $scaled <= 0) {
            throw new ShiftException('shift_cash_movement_invalid', 'Amount must be greater than zero.');
        }

        return self::fromScaled($scaled);
    }

    public static function add(string ...$values): string
    {
        return self::fromScaled(array_sum(array_map(self::toScaled(...), $values)));
    }

    public static function subtract(string $left, string ...$right): string
    {
        return self::fromScaled(self::toScaled($left) - array_sum(array_map(self::toScaled(...), $right)));
    }

    public static function multiply(string $value, int $quantity): string
    {
        return self::fromScaled(self::toScaled($value) * $quantity);
    }

    public static function toScaled(string $value): int
    {
        $negative = str_starts_with($value, '-');
        $unsigned = ltrim($value, '+-');
        [$whole, $fraction] = array_pad(explode('.', $unsigned, 2), 2, '');
        $scaled = ((int) $whole * 10000) + (int) str_pad(substr($fraction, 0, 4), 4, '0');

        return $negative ? -$scaled : $scaled;
    }

    public static function fromScaled(int $value): string
    {
        $sign = $value < 0 ? '-' : '';
        $absolute = abs($value);

        return sprintf('%s%d.%04d', $sign, intdiv($absolute, 10000), $absolute % 10000);
    }
}
