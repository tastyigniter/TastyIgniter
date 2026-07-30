<?php

declare(strict_types=1);

namespace Igniter\Cart\Concerns;

use Igniter\Cart\CartItem;

trait ActsAsItemable
{
    /**
     * Get the instance to apply on a cart item.
     *
     * @param CartItem $cartItem
     */
    public function toItem(): static
    {
        return new static(array_merge($this->toArray(), [
            'cartInstance' => array_get($this->config, 'cartInstance', 'default'),
        ]));
    }

    public static function isApplicableTo($cartItem) {}
}
