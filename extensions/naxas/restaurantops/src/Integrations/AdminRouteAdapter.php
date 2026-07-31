<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\Flame\Support\Facades\Igniter;

final class AdminRouteAdapter
{
    public function uri(): string
    {
        return Igniter::adminUri();
    }

    public function url(string $path = ''): string
    {
        return admin_url($path);
    }
}
