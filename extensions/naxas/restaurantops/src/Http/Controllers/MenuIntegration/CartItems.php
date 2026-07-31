<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\MenuIntegration;

use Illuminate\Http\JsonResponse;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Http\Requests\EnhancedCartRequest;
use Naxas\RestaurantOps\MenuIntegration\CartIdempotencyStore;
use Naxas\RestaurantOps\MenuIntegration\Contracts\OfficialCartAdapter;
use Naxas\RestaurantOps\MenuIntegration\IntegrationException;
use Naxas\RestaurantOps\MenuIntegration\MenuSelectionResolver;
use Throwable;

final class CartItems
{
    public function __construct(
        private readonly MenuSelectionResolver $resolver,
        private readonly OfficialCartAdapter $cart,
        private readonly CartIdempotencyStore $idempotency,
        private readonly AuditLogger $audit,
    ) {}

    public function quote(EnhancedCartRequest $request): JsonResponse
    {
        try {
            return response()->json(['data' => $this->public($this->resolver->resolve($request->validated()))]);
        } catch (IntegrationException $exception) {
            return $this->error($exception, $request, 'restaurantops.quote_rejected');
        }
    }

    public function store(EnhancedCartRequest $request): JsonResponse
    {
        $key = trim((string) $request->header('Idempotency-Key'));
        if ($key === '' || strlen($key) > 128) {
            return response()->json(['error' => ['code' => 'restaurantops_idempotency_key_required', 'message' => 'A valid Idempotency-Key header is required.']], 422);
        }
        $payload = $request->validated();
        if (empty($payload['configuration_hash'])) {
            return response()->json(['error' => ['code' => 'restaurantops_configuration_hash_required', 'message' => 'Quote the selection before adding it to the cart.']], 422);
        }
        $requestHash = hash('sha256', json_encode($payload, JSON_THROW_ON_ERROR));
        $claimed = false;
        try {
            if ($replay = $this->idempotency->replay($key, $requestHash)) {
                $this->audit->info('restaurantops.cart_idempotent_retry', $this->context($payload));

                return response()->json($replay + ['idempotent_replay' => true]);
            }
            $this->idempotency->claim($key, $requestHash);
            $claimed = true;
            $resolved = $this->resolver->resolve($payload);
            $response = ['data' => ['contract_version' => '1.0', 'official_cart' => $this->cart->add($resolved), 'restaurant_ops' => $this->public($resolved)], 'idempotent_replay' => false];
            $this->idempotency->remember($key, $requestHash, $response);
            $this->audit->info('restaurantops.cart_item_added', $this->context($payload) + ['cart_identity' => $resolved['canonical_cart_identity']]);

            return response()->json($response, 201);
        } catch (IntegrationException $exception) {
            if ($claimed) {
                $this->idempotency->release($key, $requestHash);
            }

            return $this->error($exception, $request, 'restaurantops.cart_rejected');
        } catch (Throwable $exception) {
            if ($claimed) {
                $this->idempotency->release($key, $requestHash);
            }
            report($exception);

            return response()->json(['error' => ['code' => 'restaurantops_cart_write_failed', 'message' => 'The enhanced cart request failed unexpectedly.']], 500);
        }
    }

    private function error(IntegrationException $exception, EnhancedCartRequest $request, string $event): JsonResponse
    {
        $this->audit->warning($event, $this->context($request->validated()) + ['error_code' => $exception->errorCode]);

        return response()->json(['error' => ['code' => $exception->errorCode, 'message' => $exception->getMessage()]], $exception->status);
    }

    private function public(array $resolved): array
    {
        return array_diff_key($resolved, ['_official_menu_options' => true]);
    }

    private function context(array $payload): array
    {
        return array_filter(['menu_id' => $payload['menu_id'] ?? null, 'location_id' => $payload['location_id'] ?? null, 'service_type' => $payload['service_type'] ?? null, 'channel' => $payload['channel'] ?? null]);
    }
}
