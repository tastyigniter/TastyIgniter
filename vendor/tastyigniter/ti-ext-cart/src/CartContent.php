<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Illuminate\Support\Collection;

class CartContent extends Collection
{
    public function quantity()
    {
        return $this->sum('qty');
    }

    public function subtotal()
    {
        return $this->sum(fn(CartItem $cartItem) => $cartItem->subtotal());
    }

    public function subtotalWithoutConditions()
    {
        return $this->sum(fn(CartItem $cartItem): float|int => $cartItem->subtotalWithoutConditions());
    }
}
