<?php

namespace Stevebauman\Purify\Tests;

use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Commands\ClearCommand;
use Stevebauman\Purify\Facades\Purify;

class NullDefinitionCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan(ClearCommand::class);

        $this->app['config']->set('purify.serializer', null);
    }

    public function test_null_cache_can_be_used()
    {
        Purify::clean('foo');

        $this->assertEmpty(Storage::allFiles('purfiy'));
    }
}
