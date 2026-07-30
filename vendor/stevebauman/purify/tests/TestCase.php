<?php

namespace Stevebauman\Purify\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Stevebauman\Purify\Commands\ClearCommand;
use Stevebauman\Purify\PurifyManager;
use Stevebauman\Purify\PurifyServiceProvider;

class TestCase extends BaseTestCase
{
    protected function tearDown(): void
    {
        $this->artisan(ClearCommand::class);

        parent::tearDown();
    }

    protected function getPackageAliases($app)
    {
        return ['Purify' => PurifyManager::class];
    }

    protected function getPackageProviders($app)
    {
        return [PurifyServiceProvider::class];
    }
}
