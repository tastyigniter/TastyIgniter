<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;

class ExtensionInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'extension:install';

    /**
     * The console command description.
     */
    protected $description = 'Install an extension from the TastyIgniter marketplace.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $extensionName = $this->argument('name');
        $manager = UpdateManager::instance();
        $manager->setLogsOutput($this->output);

        $response = $manager->requestApplyItems([[
            'name' => $extensionName,
            'type' => 'extension',
        ]]);

        $extensionDetails = array_first(array_get($response, 'data'));
        if (!$extensionDetails)
            return $this->output->writeln(sprintf('<info>Extension %s not found</info>', $extensionName));

        $code = array_get($extensionDetails, 'code');
        $hash = array_get($extensionDetails, 'hash');
        $version = array_get($extensionDetails, 'version');

        $this->output->writeln(sprintf('<info>Downloading extension: %s</info>', $code));
        $manager->downloadFile($code, $hash, [
            'name' => $code,
            'type' => 'extension',
            'ver' => $version,
        ]);

        $this->output->writeln(sprintf('<info>Extracting extension %s files</info>', $code));
        $manager->extractFile($code, 'extensions/');

        $this->output->writeln(sprintf('<info>Installing %s extension</info>', $code));
        ExtensionManager::instance()->loadExtensions();
        ExtensionManager::instance()->installExtension($code, $version);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the extension. Eg: IgniterLab.Demo'],
        ];
    }
}