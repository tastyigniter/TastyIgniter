<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\PackageManifest;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputOption;

class IgniterPackageDiscover extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:package-discover';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Rebuild the cached addons manifest.';

    /**
     * Execute the console command.
     */
    public function handle(PackageManifest $manifest): void
    {
        if ($manifest->files->exists($manifest->manifestPath)) {
            $manifest->files->delete($manifest->manifestPath);
        }

        $this->components->info('Discovering addons');

        $manifest->build();

        collect($manifest->packages())
            ->keyBy('code')
            ->keys()
            ->each(fn($description) => $this->components->task($description))
            ->whenNotEmpty(fn() => $this->newLine());
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run.'],
        ];
    }
}
