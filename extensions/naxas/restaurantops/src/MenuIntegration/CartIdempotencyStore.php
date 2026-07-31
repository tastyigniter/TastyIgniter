<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\UniqueConstraintViolationException;
use Naxas\RestaurantOps\Models\CartIdempotency;

final class CartIdempotencyStore
{
    public function __construct(private readonly Session $session) {}

    public function replay(string $key, string $requestHash): ?array
    {
        CartIdempotency::query()->where('expires_at', '<=', now())->delete();
        $entry = CartIdempotency::query()->where('scope_hash', $this->scope())->where('key_hash', $this->digest($key))->first();
        if ($entry && ! hash_equals($entry->request_hash, $requestHash)) {
            throw new IntegrationException('restaurantops_idempotency_conflict', 'The idempotency key was already used for a different selection.', 409);
        }
        if ($entry?->status === 'pending') {
            throw new IntegrationException('restaurantops_cart_write_conflict', 'The same cart request is already being processed.', 409);
        }

        return $entry?->response;
    }

    public function claim(string $key, string $requestHash): void
    {
        try {
            CartIdempotency::query()->create(['scope_hash' => $this->scope(), 'key_hash' => $this->digest($key), 'request_hash' => $requestHash, 'status' => 'pending', 'expires_at' => now()->addHour()]);
        } catch (UniqueConstraintViolationException) {
            $this->replay($key, $requestHash);
            throw new IntegrationException('restaurantops_cart_write_conflict', 'The same cart request is already being processed.', 409);
        }
    }

    public function remember(string $key, string $requestHash, array $response): void
    {
        CartIdempotency::query()->where('scope_hash', $this->scope())->where('key_hash', $this->digest($key))->where('request_hash', $requestHash)->update(['status' => 'complete', 'response' => $response]);
    }

    public function release(string $key, string $requestHash): void
    {
        CartIdempotency::query()->where('scope_hash', $this->scope())->where('key_hash', $this->digest($key))->where('request_hash', $requestHash)->where('status', 'pending')->delete();
    }

    private function digest(string $key): string
    {
        return hash('sha256', $key);
    }

    private function scope(): string
    {
        return hash_hmac('sha256', $this->session->getId(), (string) config('app.key'));
    }
}
