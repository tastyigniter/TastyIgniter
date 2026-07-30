<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Facades\Igniter\System\Helpers\CacheHelper;
use Igniter\Flame\Composer\Manager;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Models\Theme;
use Igniter\System\Classes\PackageManifest;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Facades\Assets;
use Igniter\System\Models\Extension;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class IgniterUtil extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:util';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'TastyIgniter Utility commands.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $command = implode(' ', (array)$this->argument('name'));
        $method = 'util'.studly_case($command);

        if (!method_exists($this, $method)) {
            $this->error(sprintf('Utility command "%s" does not exist!', $command));

            return;
        }

        $this->$method();
    }

    /**
     * Get the console command arguments.
     */
    #[Override]
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The utility command to perform.'],
        ];
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['admin', null, InputOption::VALUE_NONE, 'Compile admin registered bundles.'],
            ['minify', null, InputOption::VALUE_REQUIRED, 'Whether to minify the assets or not, default is 1.'],
            ['carteKey', null, InputOption::VALUE_REQUIRED, 'Specify a carteKey for set carte.'],
            ['theme', null, InputOption::VALUE_REQUIRED, 'Specify a theme code to set as default.'],
            ['extensions', null, InputOption::VALUE_NONE, 'Set the version number of all extensions to the latest available.'],
        ];
    }

    protected function utilSetVersion()
    {
        $this->comment('Setting TastyIgniter version number...');

        if (!Igniter::hasDatabase()) {
            $this->comment('Skipping - No database detected.');

            return;
        }

        $this->comment('*** TastyIgniter latest version: '.Igniter::version());

        if ($this->option('extensions')) {
            $this->setItemsVersion();
        }
    }

    protected function utilCompileScss()
    {
        $this->comment('Compiling registered asset bundles...');

        $activeTheme = resolve(ThemeManager::class)->getActiveTheme();

        $notes = $activeTheme ? Assets::buildBundles($activeTheme) : [];

        if (!$notes) {
            $this->comment('Nothing to compile!');

            return;
        }

        foreach ($notes as $note) {
            $this->comment($note);
        }
    }

    protected function utilSetCarte()
    {
        $this->comment('Setting Carte Key...');

        if (!$carteKey = $this->option('carteKey')) {
            $this->error('No carteKey defined, use --key=<key> to set a Carte');

            return;
        }

        resolve(UpdateManager::class)->applyCarte($carteKey);
    }

    protected function utilSetTheme()
    {
        if (!$themeName = $this->option('theme')) {
            $this->error('No theme defined, use --theme=<code> to set a theme');

            return;
        }

        if ($theme = Theme::activateTheme($themeName)) {
            CacheHelper::clearView();

            $this->output->writeln('Theme ['.$theme->name.'] set as default');
        }
    }

    protected function setItemsVersion()
    {
        $composerManager = resolve(Manager::class);
        $installedPackages = $composerManager->listInstalledPackages();

        $manifest = resolve(PackageManifest::class);
        $manifest->build();

        collect($manifest->packages())
            ->each(function(array $package) use ($installedPackages) {
                if (!$installedPackage = $installedPackages->get($package['code'])) {
                    $this->comment('*** '.$package['code'].' is not installed, skipping...');

                    return;
                }

                if ($package['type'] === 'tastyigniter-extension') {
                    Extension::query()->where('name', $package['code'])->update(['version' => $installedPackage['version']]);
                    $this->comment('*** '.$package['code'].' installed version: '.$installedPackage['version']);
                }

                if ($package['type'] === 'tastyigniter-theme') {
                    Theme::query()->where('code', $package['code'])->update(['version' => $installedPackage['version']]);
                    $this->comment('*** '.$package['code'].' installed version: '.$installedPackage['version']);
                }
            });
    }
}
