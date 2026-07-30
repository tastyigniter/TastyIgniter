<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic;

use Illuminate\Support\ServiceProvider;
use Override;

class AsseticServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(AssetManager::class);
    }
}
