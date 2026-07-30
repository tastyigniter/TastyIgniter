<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\UpdateManager;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Override;
use Symfony\Component\Console\Input\InputOption;

class IgniterDown extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:down';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Destroys all database tables for TastyIgniter and all extensions.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->confirmToProceed('This will DESTROY all database tables.')) {
            return;
        }

        $manager = resolve(UpdateManager::class);
        $manager->setLogsOutput($this->output);
        $manager->down($this->option('database'));
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run.'],
        ];
    }
}
