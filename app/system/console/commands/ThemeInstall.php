<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Main\Classes\ThemeManager;
use Symfony\Component\Console\Input\InputArgument;
use System\Classes\ComposerManager;
use System\Classes\UpdateManager;

class ThemeInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'theme:install';

    /**
     * The console command description.
     */
    protected $description = 'Install an theme from the TastyIgniter marketplace.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $themeName = $this->argument('name');
        $manager = UpdateManager::instance();
        $composerManager = ComposerManager::instance()->setLogsOutput($this->output);

        $response = $manager->requestApplyItems([[
            'name' => $themeName,
            'type' => 'theme',
        ]]);

        $themeDetails = array_first(array_get($response, 'data'));
        if (!$themeDetails)
            return $this->output->writeln(sprintf('<info>Theme %s not found</info>', $themeName));

        $code = array_get($themeDetails, 'code');
        $package = array_get($themeDetails, 'package');
        $version = array_get($themeDetails, 'version');

        $this->output->writeln(sprintf('<info>Installing %s theme</info>', $code));
        $composerManager->require([$package.':'.$version]);

        ThemeManager::instance()->loadThemes();
        ThemeManager::instance()->installTheme($code, $version);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the theme. Eg: demo'],
        ];
    }
}
