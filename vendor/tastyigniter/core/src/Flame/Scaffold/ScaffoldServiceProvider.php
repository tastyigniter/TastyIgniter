<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold;

use Igniter\Flame\Scaffold\Console\MakeComponent;
use Igniter\Flame\Scaffold\Console\MakeController;
use Igniter\Flame\Scaffold\Console\MakeExtension;
use Igniter\Flame\Scaffold\Console\MakeModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Override;

class ScaffoldServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakeExtension' => 'command.make.igniter.extension',
        'MakeComponent' => 'command.make.igniter.component',
        'MakeController' => 'command.make.igniter.controller',
        'MakeModel' => 'command.make.igniter.model',
    ];

    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach ($commands as $class => $command) {
            $this->{sprintf('register%sCommand', $class)}($command);
        }

        $this->commands(array_values($commands));
    }

    protected function registerMakeExtensionCommand($command)
    {
        $this->app->singleton($command, fn(Application $app): MakeExtension => new MakeExtension);
    }

    protected function registerMakeComponentCommand($command)
    {
        $this->app->singleton($command, fn(Application $app): MakeComponent => new MakeComponent);
    }

    protected function registerMakeControllerCommand($command)
    {
        $this->app->singleton($command, fn(Application $app): MakeController => new MakeController);
    }

    protected function registerMakeModelCommand($command)
    {
        $this->app->singleton($command, fn(Application $app): MakeModel => new MakeModel);
    }
}
