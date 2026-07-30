<?php

namespace Stevebauman\Purify\Tests;

use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Cache\FilesystemDefinitionCache;
use Stevebauman\Purify\Commands\ClearCommand;
use Stevebauman\Purify\Facades\Purify;
use Symfony\Component\Finder\Finder;

class FilesystemDefinitionCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('purify.serializer', [
            'disk' => 'local',
            'path' => 'purify',
            'cache' => FilesystemDefinitionCache::class,
        ]);

        $this->artisan(ClearCommand::class);
    }

    public function test_filesystem_can_be_used()
    {
        Purify::clean('foo');

        $dir = $this->app['config']->get('purify.serializer.path');

        $this->assertTrue(
            Finder::create()->in(
                Storage::path($dir)
            )->depth(0)->hasResults()
        );
    }
}
