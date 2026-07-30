<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Closure;
use Igniter\Main\Classes\ThemeManager;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Throwable;

class ThemeRemove extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:theme-remove';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Removes an existing theme.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $forceDelete = $this->option('force');
        $themeName = $this->argument('name');
        $themeManager = resolve(ThemeManager::class);

        $themeName = strtolower($themeName);
        if (!$themeManager->hasTheme($themeName)) {
            $this->error(sprintf('Unable to find a registered theme called "%s"', $themeName));

            return;
        }

        if (!$forceDelete && !$this->confirmToProceed(sprintf(
            'This will DELETE theme "%s" from the filesystem and database.',
            $themeName,
        ))) {
            return;
        }

        try {
            $this->output->writeln(sprintf('<info>Removing theme: %s</info>', $themeName));

            $themeManager->deleteTheme($themeName);
            $this->output->writeln(sprintf('<info>Deleted theme: %s</info>', $themeName));
        } catch (Throwable $throwable) {
            $this->output->writeln($throwable->getMessage());
        }
    }

    /**
     * Get the console command arguments.
     */
    #[Override]
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the theme. Eg: demo'],
        ];
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force remove.'],
        ];
    }

    /**
     * Get the default confirmation callback.
     * @return Closure
     */
    protected function getDefaultConfirmCallback()
    {
        return fn(): true => true;
    }
}
