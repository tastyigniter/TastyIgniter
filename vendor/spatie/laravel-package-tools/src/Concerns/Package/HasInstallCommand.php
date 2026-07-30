<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Spatie\LaravelPackageTools\Commands\InstallCommand;

trait HasInstallCommand
{
    public function hasInstallCommand($callable): static
    {
        $installCommand = new InstallCommand($this);

        $callable($installCommand);

        $this->consoleCommands[] = $installCommand;

        return $this;
    }
}
