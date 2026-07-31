<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Naxas\RestaurantOps\MenuConfiguration\Exceptions\InvalidConfiguration;

final class CartCompatibilityMapper
{
    public function isEnhanced(array $payload): bool
    {
        return isset($payload['restaurant_ops']);
    }

    public function mapLegacy(array $payload): array
    {
        return ['mode' => 'legacy', 'options' => $payload['menu_options'] ?? $payload['options'] ?? []];
    }

    public function mapEnhanced(array $payload, string $currentHash): array
    {
        $data = $payload['restaurant_ops'] ?? [];
        if (($data['configuration_hash'] ?? null) !== $currentHash) {
            throw new InvalidConfiguration('Menu configuration changed; refresh before ordering.');
        }
        $identity = ['variant_id' => $data['variant_id'] ?? null, 'modifiers' => $this->canonical($data['modifiers'] ?? []), 'combo' => $this->canonical($data['combo'] ?? []), 'location_id' => $data['location_id'] ?? null, 'service_type' => $data['service_type'] ?? null];

        return ['mode' => 'enhanced', 'options' => $payload['menu_options'] ?? [], 'identity' => $identity, 'identity_hash' => hash('sha256', json_encode($identity, JSON_THROW_ON_ERROR))];
    }

    private function canonical(array $values): array
    {
        usort($values, fn (array $a, array $b): int => [(int) ($a['id'] ?? 0), (int) ($a['quantity'] ?? 1)] <=> [(int) ($b['id'] ?? 0), (int) ($b['quantity'] ?? 1)]);

        return $values;
    }
}
