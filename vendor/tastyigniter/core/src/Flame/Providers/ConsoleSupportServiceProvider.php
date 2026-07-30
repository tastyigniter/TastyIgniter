<?php

declare(strict_types=1);

namespace Igniter\Flame\Providers;

use Igniter\Flame\Database\MigrationServiceProvider;
use Illuminate\Foundation\Providers\ComposerServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider as BaseServiceProvider;

class ConsoleSupportServiceProvider extends BaseServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array<string>
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        MigrationServiceProvider::class,
        ComposerServiceProvider::class,
    ];
}
