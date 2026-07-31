<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\Local\Models\Location;

final class LocationAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return Location::class;
    }
}
