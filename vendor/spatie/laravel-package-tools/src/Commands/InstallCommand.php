<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelPackageTools\Commands\Concerns\AskToRunMigrations;
use Spatie\LaravelPackageTools\Commands\Concerns\AskToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Commands\Concerns\PublishesResources;
use Spatie\LaravelPackageTools\Commands\Concerns\SupportsServiceProviderInApp;
use Spatie\LaravelPackageTools\Commands\Concerns\SupportsStartWithEndWith;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    use AskToRunMigrations;
    use AskToStarRepoOnGitHub;
    use PublishesResources;
    use SupportsServiceProviderInApp;
    use SupportsStartWithEndWith;

    protected Package $package;

    public function __construct(Package $package)
    {
        $this->signature = $package->shortName() . ':install';

        $this->description = 'Install ' . $package->name;

        $this->package = $package;

        $this->hidden = true;

        parent::__construct();
    }

    public function handle()
    {
        $this
            ->processStartWith()
            ->processPublishes()
            ->processAskToRunMigrations()
            ->processCopyServiceProviderInApp()
            ->processStarRepo()
            ->processEndWith();

        $this->info("{$this->package->shortName()} has been installed!");
    }
}
