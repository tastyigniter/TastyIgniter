<?php

namespace Admin\Traits;

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
}
