<?php

declare(strict_types=1);

namespace Igniter\Main\Providers;

use Igniter\User\Classes\PermissionManager;
use Illuminate\Support\ServiceProvider;
use Override;

class PermissionServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->callAfterResolving(PermissionManager::class, function($manager) {
            $manager->registerCallback(function($manager) {
                $manager->registerPermissions('System', [
                    'Admin.MediaManager' => [
                        'label' => 'igniter::main.permissions.media_manager',
                        'group' => 'igniter::admin.permissions.name',
                    ],
                    'Site.Themes' => [
                        'label' => 'igniter::main.permissions.themes',
                        'group' => 'igniter::system.permissions.name',
                    ],
                ]);
            });
        });
    }
}
