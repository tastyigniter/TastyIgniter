<?php

namespace Stevebauman\Purify\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Cache\CacheDefinitionCache;
use Stevebauman\Purify\Cache\FilesystemDefinitionCache;

class ClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'purify:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush the HTML purifier serializer cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Repository $config)
    {
        if (empty($serializer = $config->get('purify.serializer'))) {
            return $this->error(
                'Purifier serializer path is not defined. Did you set it to null or forget to publish the configuration?'
            );
        }

        /** @var class-string $cache */
        $cache = $serializer['cache'];

        if (is_a($cache, FilesystemDefinitionCache::class, true)) {
            $disk = Storage::disk($serializer['disk']);

            $disk->deleteDirectory($serializer['path']);

            $disk->makeDirectory($serializer['path']);

            return $this->info('HTML Purifier serializer filesystem cache cleared successfully.');
        }

        if (is_a($cache, CacheDefinitionCache::class, true)) {
            $cache = Cache::driver($serializer['driver']);

            $cache->clear();

            return $this->info('HTML Purifier serializer cache cleared successfully.');
        }

        return $this->error(
            sprintf('Unable to determine a clear cache strategy with the given cache instance [%s].', $cache)
        );
    }
}
