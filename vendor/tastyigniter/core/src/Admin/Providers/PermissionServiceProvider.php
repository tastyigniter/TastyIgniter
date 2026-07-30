<?php

declare(strict_types=1);

namespace Igniter\Admin\Providers;

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
                $manager->registerPermissions('Admin', [
                    'Admin.Dashboard' => [
                        'label' => 'igniter::admin.permissions.dashboard',
                        'group' => 'igniter::admin.permissions.name',
                    ],
                    'Admin.Statuses' => [
                        'label' => 'igniter::admin.permissions.statuses',
                        'group' => 'igniter::admin.permissions.name',
                    ],
                ]);
            });
        });
    }
}
