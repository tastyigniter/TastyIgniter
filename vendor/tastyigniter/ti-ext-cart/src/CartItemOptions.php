<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Illuminate\Support\Collection;

class CartItemOptions extends Collection
{
    public function subtotal()
    {
        return $this->sum(fn(CartItemOption $option): float|int => $option->subtotal());
    }
}
