<?php

namespace Laravel\Reverb;

use Illuminate\Support\Manager;

class ApplicationManager extends Manager
{
    /**
     * Create an instance of the configuration driver.
     */
    public function createConfigDriver(): ConfigApplicationProvider
    {
        return new ConfigApplicationProvider(
            collect($this->config->get('reverb.apps.apps', []))
        );
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('reverb.apps.provider', 'config');
    }
}
