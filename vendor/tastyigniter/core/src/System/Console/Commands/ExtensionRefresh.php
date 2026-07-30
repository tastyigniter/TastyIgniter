<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Classes\UpdateManager;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use InvalidArgumentException;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ExtensionRefresh extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:extension-refresh';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Rollback and re-migrate an existing extension.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $extensionName = $this->argument('name');
        $extensionManager = resolve(ExtensionManager::class);

        $extensionName = $extensionManager->getIdentifier(strtolower($extensionName));
        if (!$extensionManager->hasExtension($extensionName)) {
            throw new InvalidArgumentException(sprintf('Extension "%s" not found.', $extensionName));
        }

        $updateManager = resolve(UpdateManager::class)->setLogsOutput($this->output);

        if (($step = (int)$this->option('step')) !== 0) {
            $this->output->writeln(sprintf('<info>Rolling back extension %s...</info>', $extensionName));
            $updateManager->rollbackExtension($extensionName, [
                'pretend' => $this->option('pretend'),
                'step' => $step,
            ]);
        } else {
            $this->output->writeln(sprintf('<info>Purging extension %s...</info>', $extensionName));
            $updateManager->purgeExtension($extensionName);
            $updateManager->migrateExtension($extensionName);
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
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run'],
            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted'],
        ];
    }
}
