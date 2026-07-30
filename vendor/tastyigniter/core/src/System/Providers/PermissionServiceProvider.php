<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

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
                    'Admin.Notifications' => [
                        'label' => 'igniter::system.permissions.notifications',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Admin.Extensions' => [
                        'label' => 'igniter::system.permissions.extensions',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Admin.MailTemplates' => [
                        'label' => 'igniter::system.permissions.mail_templates',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Site.Countries' => [
                        'label' => 'igniter::system.permissions.countries',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Site.Currencies' => [
                        'label' => 'igniter::system.permissions.currencies',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Site.Languages' => [
                        'label' => 'igniter::system.permissions.languages',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Site.Settings' => [
                        'label' => 'igniter::system.permissions.settings',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Site.Updates' => [
                        'label' => 'igniter::system.permissions.updates',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Admin.SystemLogs' => [
                        'label' => 'igniter::system.permissions.system_logs',
                        'group' => 'igniter::system.permissions.name',
                    ],
                    'Admin.SystemInfo' => [
                        'label' => 'igniter::system.permissions.system_info',
                        'group' => 'igniter::system.permissions.name',
                    ],
                ]);
            });
        });
    }
}
