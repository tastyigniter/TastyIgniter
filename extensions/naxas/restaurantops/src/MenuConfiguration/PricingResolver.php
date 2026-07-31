<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Naxas\RestaurantOps\MenuConfiguration\Exceptions\InvalidConfiguration;

/** Deterministic server-side calculator. Inputs must already be resolved from trusted models. */
final class PricingResolver
{
    public function resolve(array $configuration): array
    {
        $base = $this->minor($configuration['special_price'] ?? $configuration['base_price'] ?? '0');
        $variant = $this->minor($configuration['variant_price'] ?? '0');
        if (($configuration['variant_price_mode'] ?? 'adjustment') === 'absolute') {
            $variant -= $base;
        }
        $modifier = 0;
        $modifierLines = [];
        foreach ($configuration['modifiers'] ?? [] as $value) {
            $quantity = (int) ($value['quantity'] ?? 1);
            if ($quantity < 0) {
                throw new InvalidConfiguration('Modifier quantity cannot be negative.');
            }
            $free = min($quantity, (int) ($value['free_quantity'] ?? 0));
            $line = $this->minor($value['unit_price'] ?? '0') * ($quantity - $free);
            $modifier += $line;
            $modifierLines[] = ['id' => (int) $value['id'], 'quantity' => $quantity, 'free_quantity' => $free, 'unit_price' => $this->decimal($this->minor($value['unit_price'] ?? '0')), 'total' => $this->decimal($line)];
        }
        $combo = array_sum(array_map(fn (array $choice): int => $this->minor($choice['surcharge'] ?? '0') * (int) ($choice['quantity'] ?? 1), $configuration['combo_choices'] ?? []));
        $context = array_key_exists('context_price_override', $configuration) && $configuration['context_price_override'] !== null
            ? $this->minor($configuration['context_price_override']) - ($base + $variant) : 0;
        $subtotal = $base + $variant + $modifier + $combo + $context;
        if ($subtotal < 0) {
            throw new InvalidConfiguration('Resolved item price cannot be negative.');
        }
        $breakdown = ['base_price' => $this->decimal($base), 'variant_adjustment' => $this->decimal($variant), 'modifiers' => $modifierLines, 'modifier_total' => $this->decimal($modifier), 'combo_adjustment' => $this->decimal($combo), 'location_service_adjustment' => $this->decimal($context), 'subtotal' => $this->decimal($subtotal)];
        $hashSource = ['menu_id' => $configuration['menu_id'] ?? null, 'variant_id' => $configuration['variant_id'] ?? null, 'context' => $configuration['context'] ?? [], 'breakdown' => $breakdown, 'version' => $configuration['version'] ?? 1];

        return $breakdown + ['configuration_hash' => hash('sha256', json_encode($hashSource, JSON_THROW_ON_ERROR))];
    }

    private function minor(int|float|string|null $amount): int
    {
        $value = trim((string) ($amount ?? '0'));
        if (! preg_match('/^-?\d+(?:\.\d{1,4})?$/', $value)) {
            throw new InvalidConfiguration('Invalid decimal price.');
        }
        [$whole, $fraction] = array_pad(explode('.', $value, 2), 2, '');
        $negative = str_starts_with($whole, '-');
        $whole = ltrim($whole, '-');
        $minor = ((int) $whole * 10000) + (int) str_pad($fraction, 4, '0');

        return $negative ? -$minor : $minor;
    }

    private function decimal(int $minor): string
    {
        $sign = $minor < 0 ? '-' : '';
        $minor = abs($minor);

        return $sign.intdiv($minor, 10000).'.'.str_pad((string) ($minor % 10000), 4, '0', STR_PAD_LEFT);
    }
}
