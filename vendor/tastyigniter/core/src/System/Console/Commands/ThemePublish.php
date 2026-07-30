<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Foundation\Console\VendorPublishCommand;
use Override;
use Symfony\Component\Console\Input\InputOption;

class ThemePublish extends VendorPublishCommand
{
    use ConfirmableTrait;

    protected $name = 'igniter:theme-publish';

    protected $description = 'Publish active theme publishable files from extensions';

    protected $signature;

    protected ?Theme $activeTheme = null;

    /**
     * Execute the console command.
     */
    #[Override]
    public function handle(): void
    {
        $this->comment('Publishing theme assets...');

        $this->determineWhatShouldBePublished();

        $published = false;

        $activeThemePath = $this->activeTheme->getPath();
        foreach (Igniter::publishableThemeFiles() as $path => $publishTo) {
            $this->publishItem($path, $activeThemePath.$publishTo);
            $published = true;
        }

        if ($published === false) {
            $this->comment('No publishable custom files for theme ['.$this->activeTheme->getName().'].');
        } else {
            $this->info('Publishing complete.');
        }
    }

    #[Override]
    protected function determineWhatShouldBePublished()
    {
        throw_unless(
            $this->activeTheme = resolve(ThemeManager::class)->getActiveTheme(),
            new SystemException(lang('igniter::admin.alert_error_nothing')),
        );

        throw_if(
            $this->activeTheme->locked,
            new SystemException(lang('igniter::system.themes.alert_theme_locked')),
        );

        throw_if(
            !str_starts_with($this->activeTheme->getPath(), theme_path()),
            new SystemException(lang('igniter::system.themes.alert_no_publish_custom')),
        );
    }

    #[Override]
    protected function getOptions(): array
    {
        return [
            ['existing', null, InputOption::VALUE_NONE, 'Publish and overwrite only the files that have already been published'],
            ['force', null, InputOption::VALUE_NONE, 'Force publish.'],
        ];
    }
}
