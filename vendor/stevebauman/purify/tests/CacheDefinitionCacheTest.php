<?php

namespace Stevebauman\Purify\Tests;

use Stevebauman\Purify\Cache\CacheDefinitionCache;
use Stevebauman\Purify\Facades\Purify;
use Symfony\Component\Finder\Finder;

class CacheDefinitionCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('purify.serializer', [
            'driver' => 'file',
            'cache' => CacheDefinitionCache::class,
        ]);
    }

    public function test_cache_can_be_used()
    {
        Purify::clean('foo');

        $dir = $this->app['config']->get('cache.stores.file.path');

        $this->assertTrue(
            Finder::create()
                ->in($dir)
                ->depth(0)
                ->hasResults()
        );
    }
}
