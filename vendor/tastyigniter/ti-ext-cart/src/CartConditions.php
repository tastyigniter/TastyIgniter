<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Illuminate\Support\Collection;

class CartConditions extends Collection
{
    public function apply(CartContent $content)
    {
        return $this
            ->sorted()
            ->reduce(fn($total, CartCondition $condition) => $condition->withTarget($content)->apply($total), $content->subtotal());
    }

    public function applied()
    {
        return $this->filter(fn(CartCondition $condition) => $condition->isValid());
    }

    public function sorted()
    {
        return $this->sortBy(fn($condition) => $condition->priority);
    }
}
