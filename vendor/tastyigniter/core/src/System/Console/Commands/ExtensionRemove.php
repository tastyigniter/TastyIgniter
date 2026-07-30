<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\ExtensionManager;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Throwable;

class ExtensionRemove extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:extension-remove';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Removes an existing extension.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $forceDelete = $this->option('force');
        $extensionName = $this->argument('name');
        $extensionManager = resolve(ExtensionManager::class);

        $extensionName = $extensionManager->getIdentifier(strtolower($extensionName));
        if (!$extensionManager->hasExtension($extensionName)) {
            $this->error(sprintf('Unable to find a registered extension called "%s"', $extensionName));

            return;
        }

        if (!$forceDelete && !$this->confirmToProceed(sprintf(
            'This will DELETE extension "%s" from the filesystem and database.',
            $extensionName,
        ))) {
            return;
        }

        try {
            $this->output->writeln(sprintf('<info>Removing extension: %s</info>', $extensionName));

            $extensionManager->deleteExtension($extensionName);
            $this->output->writeln(sprintf('<info>Deleted extension: %s</info>', $extensionName));
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
            ['name', InputArgument::REQUIRED, 'The name of the extension. Eg: IgniterLab.Demo'],
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
}
