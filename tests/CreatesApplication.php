<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Http\Kernel as HttpKernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        $app->make(HttpKernel::class)->bootstrap();

        $app['cache']->setDefaultDriver('array');
        $app->setLocale('en');

        return $app;
    }
}
