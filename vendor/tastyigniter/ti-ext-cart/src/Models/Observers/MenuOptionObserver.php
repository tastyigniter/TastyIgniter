<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Observers;

use Igniter\Cart\Models\MenuOption;

class MenuOptionObserver
{
    public function saved(MenuOption $menuOption): void
    {
        $menuOption->restorePurgedValues();

        if (array_key_exists('values', $attributes = $menuOption->getAttributes())) {
            $menuOption->addOptionValues(array_get($attributes, 'values', []));
        }
    }

    public function deleting(MenuOption $menuOption): void
    {
        $menuOption->locations()->detach();
    }
}
