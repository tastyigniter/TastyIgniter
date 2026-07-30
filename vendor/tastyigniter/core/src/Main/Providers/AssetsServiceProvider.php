<?php

declare(strict_types=1);

namespace Igniter\Main\Providers;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\ThemeManager;
use Igniter\System\Libraries\Assets;
use Illuminate\Support\ServiceProvider;
use Override;

class AssetsServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        if (!$this->app->runningInConsole() && !Igniter::runningInAdmin()) {
            $this->registerAssets();
        }
    }

    protected function registerAssets()
    {
        $this->app->resolving('assets', function(Assets $manager) {
            $manager->registerSourcePath(Igniter::themesPath());

            if ($activeTheme = resolve(ThemeManager::class)->getActiveTheme()) {
                $manager->addAssetsFromThemeManifest($activeTheme);
            }
        });
    }
}
