<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Execute the console command.
     */
    public function clear(): void
    {
        Cache::flush();
        $this->clearInternal();
    }

    public function clearInternal(): void
    {
        $this->clearCache();
        $this->clearView();
        $this->clearTemplates();

        $this->clearCombiner();

        $this->clearCompiled();
    }

    public function clearView(): void
    {
        $path = config('view.compiled');
        foreach (File::glob($path.'/*') as $view) {
            File::delete($view);
        }
    }

    public function clearCombiner(): void
    {
        $this->clearDirectory('/igniter/combiner');
    }

    public function clearCache(): void
    {
        $path = config('igniter-pagic.parsedTemplateCachePath', storage_path('/igniter/cache'));
        if (!File::isDirectory($path)) {
            return;
        }

        foreach (File::directories($path) as $directory) {
            File::deleteDirectory($directory);
        }
    }

    public function clearTemplates() {}

    public function clearCompiled(): void
    {
        File::delete(Igniter::getCachedAddonsPath());
        File::delete(App::getCachedPackagesPath());
        File::delete(App::getCachedServicesPath());
    }

    public function clearDirectory(string $path): void
    {
        if (!File::isDirectory(storage_path().$path)) {
            return;
        }

        foreach (File::directories(storage_path().$path) as $directory) {
            File::deleteDirectory($directory);
        }
    }
}
