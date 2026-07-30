<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\System\Classes\PackageInfo;
use Igniter\System\Classes\UpdateManager;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Throwable;

class ExtensionInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:extension-install';

    /**
     * The console command description.
     */
    protected $description = 'Install an extension from the TastyIgniter marketplace.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $extensionName = $this->argument('name');
        $updateManager = resolve(UpdateManager::class)->setLogsOutput($this->output);

        $itemDetail = rescue(fn() => $updateManager->requestItemDetail([
            'name' => $extensionName,
            'type' => 'extension',
        ]), fn() => null, false) ?? [];

        if (!$itemDetail || !array_has($itemDetail, 'package') || array_get($itemDetail, 'code') !== $extensionName) {
            $this->output->writeln(sprintf('<info>Extension %s not found</info>', $extensionName));

            return;
        }

        try {
            $this->output->writeln(sprintf('<info>Installing %s extension</info>', $extensionName));

            $packageInfo = PackageInfo::fromArray($itemDetail);
            $packages = $updateManager->install([$packageInfo], $this->output);
            $updateManager->completeInstall($packages);
            $updateManager->migrateExtension($packageInfo->code);
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
}
