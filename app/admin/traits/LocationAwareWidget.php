<?php

namespace Admin\Traits;

use Admin\Facades\AdminLocation;
use Admin\Models\Location;

trait LocationAwareWidget
{
    protected function isLocationAware($config)
    {
        $locationAware = $config['locationAware'] ?? FALSE;

        return $locationAware && $this->controller->getUserLocation();
    }

    /**
     * Apply location scope where required
     */
    protected function locationApplyScope($query)
    {
        if (is_null($ids = AdminLocation::getAll()))
            return;

        $model = $query->getModel();
        if ($model instanceof Location) {
            $query->whereIn('location_id', $ids);

            return;
        }

        if (!in_array(\Admin\Traits\Locationable::class, class_uses($model)))
            return;

        $query->whereHasLocation($ids);
    }
}
