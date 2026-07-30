<?php

declare(strict_types=1);

namespace Igniter\Local\Traits;

use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;

trait LocationAwareWidget
{
    protected function isLocationAware(array $config): bool
    {
        $locationAware = $config['locationAware'] ?? false;

        return $locationAware && LocationFacade::check();
    }

    /**
     * Apply location scope where required
     */
    protected function locationApplyScope($query, $config = [])
    {
        $model = $query->getModel();
        if (!$model instanceof Location && !in_array(Locationable::class, class_uses($model))) {
            return;
        }

        if (empty($ids = LocationFacade::currentOrAssigned())) {
            return;
        }

        if ($model instanceof Location) {
            $query->whereIn('location_id', $ids);
        } elseif (array_get($config, 'locationAware') === 'assignedOnly') {
            $query->whereHasLocation($ids);
        } else {
            $query->whereHasOrDoesntHaveLocation($ids);
        }
    }
}
