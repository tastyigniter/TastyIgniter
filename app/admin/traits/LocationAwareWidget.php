<?php

namespace Admin\Traits;

use Admin\Facades\AdminLocation;
use Admin\Models\Locations_model;
use Exception;

trait LocationAwareWidget
{
    protected function isLocationAware($config)
    {
        $locationAware = $config['locationAware'] ?? 'skip';
        if (!in_array($locationAware, ['skip', 'show', 'hide']))
            throw new Exception('Valid values for [locationAware] property are (none,show,hide)');

        if ($this->controller->getUserLocation())
            return $locationAware == 'hide';

        return $locationAware == 'show';
    }

    /**
     * Apply location scope where required
     */
    protected function locationApplyScope($query)
    {
        if (is_null($ids = AdminLocation::getAll()))
            return;

        $model = $query->getModel();
        if ($model instanceof Locations_model) {
            $query->whereIn('location_id', $ids);

            return;
        }

        if (!in_array(\Admin\Traits\Locationable::class, class_uses($model)))
            return;

        $query->whereHasLocation($ids);
    }
}
