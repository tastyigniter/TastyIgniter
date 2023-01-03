<?php

namespace System\Helpers;

use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    use \Igniter\Flame\Traits\Singleton;

    /**
     * Execute the console command.
     */
    public static function clear()
    {
        Cache::flush();
        self::clearInternal();
    }

    public static function clearInternal()
    {
        $instance = self::instance();
        $instance->clearCache();
        $instance->clearView();
        $instance->clearTemplates();

        $instance->clearCombiner();

        $instance->clearMeta();
    }

    public function clearView()
    {
        $path = config()->get('view.compiled');
        foreach (File::glob("{$path}/*") as $view) {
            File::delete($view);
        }
    }

    public function clearCombiner()
    {
        $this->clearDirectory('/system/combiner');
    }

    public function clearCache()
    {
        $this->clearDirectory('/system/cache');
    }

    public function clearTemplates()
    {
        $this->clearDirectory('/system/templates');
    }

    public function clearMeta()
    {
        File::delete(App::getCachedClassesPath());
        File::delete(App::getCachedServicesPath());
    }

    public function clearDirectory($path)
    {
        if (!File::isDirectory(storage_path().$path))
            return;

        foreach (File::directories(storage_path().$path) as $directory) {
            File::deleteDirectory($directory);
        }
    }
}
