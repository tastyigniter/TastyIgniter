<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\Cart\Models\Menu;

final class MenuAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return Menu::class;
    }
}
