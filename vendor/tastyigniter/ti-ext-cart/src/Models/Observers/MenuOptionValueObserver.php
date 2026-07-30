<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Observers;

use Igniter\Cart\Models\MenuOptionValue;

class MenuOptionValueObserver
{
    public function deleting(MenuOptionValue $menuOptionValue): void
    {
        $menuOptionValue->ingredients()->detach();
    }
}
