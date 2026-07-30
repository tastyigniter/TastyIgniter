<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Observers;

use Igniter\Cart\Models\Menu;

class MenuObserver
{
    public function saved(Menu $menu): void
    {
        $menu->restorePurgedValues();

        if (array_key_exists('menu_options', $attributes = $menu->getAttributes())) {
            $menu->addMenuOption((array)array_get($attributes, 'menu_options', []));
        }

        if (array_key_exists('special', $attributes)) {
            $menu->addMenuSpecial((array)array_get($attributes, 'special', []));
        }
    }

    public function deleting(Menu $menu): void
    {
        $menu->menu_options()->delete();
        $menu->special()->delete();
        $menu->categories()->detach();
        $menu->mealtimes()->detach();
        $menu->ingredients()->detach();
        $menu->locations()->detach();
    }
}
