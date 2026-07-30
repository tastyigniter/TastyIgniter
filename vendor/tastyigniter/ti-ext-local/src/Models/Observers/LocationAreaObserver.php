<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Observers;

use Igniter\Local\Models\LocationArea;

class LocationAreaObserver
{
    public function saved(LocationArea $locationArea): void
    {
        if (!$locationArea->defaultable()->whereIsDefault()->exists()) {
            LocationArea::updateDefault($locationArea->getKey());
        }
    }
}
