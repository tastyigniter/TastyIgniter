<?php namespace System\Helpers;

use App;
use Cache;
use File;

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
        $instance->clearTemplates();

        $instance->clearCombiner();

        $instance->clearMeta();
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
        foreach (File::directories(storage_path().$path) as $directory) {
            File::deleteDirectory($directory);
        }
    }
}
