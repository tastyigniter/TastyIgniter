<?php

declare(strict_types=1);

namespace Igniter\Flame\Filesystem;

use Illuminate\Support\ServiceProvider;
use Override;

class FilesystemServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(Filesystem::class, function(): Filesystem {
            $config = $this->app['config'];
            $files = new Filesystem;
            $files->filePermissions = $config->get('igniter-system.filePermissions', null);
            $files->folderPermissions = $config->get('igniter-system.folderPermissions', null);
            $files->addPathSymbol('$', public_path('vendor'));
            $files->addPathSymbol('~', base_path());

            return $files;
        });
    }
}
