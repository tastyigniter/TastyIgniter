<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\PackageInfo;
use Igniter\System\Classes\UpdateManager;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Throwable;

class ThemeInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:theme-install';

    /**
     * The console command description.
     */
    protected $description = 'Install an theme from the TastyIgniter marketplace.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $themeName = $this->argument('name');
        $updateManager = resolve(UpdateManager::class)->setLogsOutput($this->output);

        $itemDetail = $updateManager->requestItemDetail([
            'name' => $themeName,
            'type' => 'theme',
        ]);

        if (!$itemDetail || !array_has($itemDetail, 'package') || array_get($itemDetail, 'code') !== $themeName) {
            $this->output->writeln(sprintf('<info>Theme %s not found</info>', $themeName));

            return;
        }

        try {
            $this->output->writeln(sprintf('<info>Installing %s theme</info>', $themeName));

            $packageInfo = PackageInfo::fromArray($itemDetail);
            $packages = $updateManager->install([$packageInfo], $this->output);
            $updateManager->completeInstall($packages);
            $updateManager->migrate();
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
            ['name', InputArgument::REQUIRED, 'The name of the theme. Eg: igniter-orange'],
        ];
    }
}
