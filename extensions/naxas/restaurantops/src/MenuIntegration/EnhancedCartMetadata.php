<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

final class EnhancedCartMetadata
{
    private const string PREFIX = '[restaurant_ops:v1:';

    public function encode(string $note, array $metadata): string
    {
        $encoded = rtrim(strtr(base64_encode(json_encode($metadata, JSON_THROW_ON_ERROR)), '+/', '-_'), '=');

        return $note."\n".self::PREFIX.$encoded.']';
    }

    public function decode(?string $comment): ?array
    {
        if (! preg_match('/(?:^|\\n)\\[restaurant_ops:v1:([A-Za-z0-9_-]+)]$/', (string) $comment, $matches)) {
            return null;
        }
        $payload = base64_decode(strtr($matches[1], '-_', '+/'), true);
        if ($payload === false) {
            return null;
        }

        $decoded = json_decode($payload, true);

        return is_array($decoded) && ($decoded['contract_version'] ?? null) === '1.0' ? $decoded : null;
    }

    public function note(?string $comment): string
    {
        return trim((string) preg_replace('/(?:^|\\n)\\[restaurant_ops:v1:[A-Za-z0-9_-]+]$/', '', (string) $comment));
    }
}
