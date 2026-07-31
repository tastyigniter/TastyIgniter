<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

use Igniter\Cart\Classes\CartManager;
use Naxas\RestaurantOps\MenuIntegration\Contracts\OfficialCartAdapter;
use Throwable;

final class TastyIgniterCartAdapter implements OfficialCartAdapter
{
    public function __construct(private readonly EnhancedCartMetadata $metadata) {}

    public function add(array $resolved): array
    {
        $metadata = array_diff_key($resolved, ['_official_menu_options' => true]);
        $comment = $this->metadata->encode($resolved['item_note'], $metadata);
        try {
            $manager = app(CartManager::class);
            $item = $manager->addCartItem($resolved['menu_id'], [
                'quantity' => $resolved['quantity'],
                'comment' => $comment,
                'menu_options' => $resolved['_official_menu_options'],
            ]);
            $optionSubtotal = (float) $item->options->subtotal();
            $basePrice = (float) $resolved['authoritative_unit_total'] - $optionSubtotal;
            if ($basePrice < 0) {
                throw new IntegrationException('restaurantops_cart_write_failed', 'Official option pricing exceeds the authoritative enhanced total.', 409);
            }
            $item = $manager->getCart()->update($item->rowId, [
                'name' => $item->name, 'price' => $basePrice, 'qty' => $item->qty,
                'options' => $item->options, 'comment' => $comment,
            ]);
        } catch (IntegrationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);
            throw new IntegrationException('restaurantops_cart_write_failed', 'The official cart could not add the enhanced item.', 409);
        }

        return [
            'row_id' => $item->rowId, 'quantity' => $item->qty,
            'name' => $item->name, 'unit_total' => $resolved['authoritative_unit_total'],
            'line_total' => $resolved['authoritative_line_total'],
            'canonical_cart_identity' => $resolved['canonical_cart_identity'],
        ];
    }
}
