<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasCommands
{
    public array $commands = [];
    public array $consoleCommands = [];

    public function hasCommand(string $commandClassName): static
    {
        $this->commands[] = $commandClassName;

        return $this;
    }

    public function hasCommands(...$commandClassNames): static
    {
        $this->commands = array_merge(
            $this->commands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }

    public function hasConsoleCommand(string $commandClassName): static
    {
        $this->consoleCommands[] = $commandClassName;

        return $this;
    }

    public function hasConsoleCommands(...$commandClassNames): static
    {
        $this->consoleCommands = array_merge(
            $this->consoleCommands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }
}
