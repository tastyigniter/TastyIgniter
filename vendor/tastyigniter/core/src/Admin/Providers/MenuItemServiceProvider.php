<?php

declare(strict_types=1);

namespace Igniter\Admin\Providers;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Admin\Classes\Navigation;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\ServiceProvider;
use Override;

class MenuItemServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        if (Igniter::runningInAdmin() || app()->runningUnitTests()) {
            $this->registerMainMenuItems();
            $this->registerNavMenuItems();
        }
    }

    /**
     * Register admin top menu navigation items
     */
    protected function registerMainMenuItems()
    {
        AdminMenu::registerCallback(function(Navigation $manager) {
            $manager->registerMainItems([
                MainMenuItem::link('preview')
                    ->icon('fa-store')
                    ->priority(10)
                    ->attributes([
                        'class' => 'nav-link front-end',
                        'title' => lang('igniter::admin.side_menu.storefront'),
                        'href' => page_url('home'),
                        'target' => '_blank',
                    ]),
                MainMenuItem::link('help')
                    ->icon('fa-circle-question')
                    ->priority(15)
                    ->attributes([
                        'class' => 'nav-link front-end',
                        'title' => lang('igniter::admin.text_support'),
                        'href' => 'https://tastyigniter.com/support',
                        'target' => '_blank',
                    ]),
                MainMenuItem::link('settings')
                    ->icon('fa-gear')
                    ->priority(20)
                    ->attributes([
                        'class' => 'nav-link front-end',
                        'title' => lang('igniter::admin.side_menu.setting'),
                        'href' => admin_url('settings'),
                    ]),
            ]);
        });
    }

    /**
     * Register admin menu navigation items
     */
    protected function registerNavMenuItems()
    {
        AdminMenu::registerCallback(function(Navigation $manager) {
            $manager->registerNavItems([
                'dashboard' => [
                    'priority' => 0,
                    'class' => 'dashboard admin',
                    'href' => admin_url('dashboard'),
                    'icon' => 'fa-tachometer-alt',
                    'title' => lang('igniter::admin.side_menu.dashboard'),
                ],
                'restaurant' => [
                    'priority' => 40,
                    'class' => 'restaurant',
                    'icon' => 'fa-utensils',
                    'title' => lang('igniter::admin.side_menu.restaurant'),
                    'child' => [],
                ],
                'marketing' => [
                    'priority' => 50,
                    'class' => 'marketing',
                    'icon' => 'fa-bullseye',
                    'title' => lang('igniter::admin.side_menu.marketing'),
                    'child' => [],
                ],
                'design' => [
                    'priority' => 200,
                    'class' => 'design',
                    'icon' => 'fa-paint-brush',
                    'title' => lang('igniter::admin.side_menu.design'),
                    'child' => [
                        'themes' => [
                            'priority' => 10,
                            'class' => 'themes',
                            'href' => admin_url('themes'),
                            'title' => lang('igniter::admin.side_menu.theme'),
                            'permission' => 'Site.Themes',
                        ],
                        'mail_templates' => [
                            'priority' => 20,
                            'class' => 'mail_templates',
                            'href' => admin_url('mail_templates'),
                            'title' => lang('igniter::admin.side_menu.mail_template'),
                            'permission' => 'Admin.MailTemplates',
                        ],
                    ],
                ],
                'tools' => [
                    'priority' => 400,
                    'class' => 'tools',
                    'icon' => 'fa-wrench',
                    'title' => lang('igniter::admin.side_menu.tool'),
                    'child' => [
                        'media_manager' => [
                            'priority' => 10,
                            'class' => 'media_manager',
                            'href' => admin_url('media_manager'),
                            'title' => lang('igniter::admin.side_menu.media_manager'),
                            'permission' => 'Admin.MediaManager',
                        ],
                    ],
                ],
                'system' => [
                    'priority' => 999,
                    'class' => 'system',
                    'icon' => 'fa-cog',
                    'title' => lang('igniter::admin.side_menu.system'),
                    'child' => [
                        'settings' => [
                            'priority' => 0,
                            'class' => 'settings',
                            'href' => admin_url('settings'),
                            'title' => lang('igniter::admin.side_menu.setting'),
                            'permission' => 'Site.Settings',
                        ],
                        'extensions' => [
                            'priority' => 40,
                            'class' => 'extensions',
                            'href' => admin_url('extensions'),
                            'title' => lang('igniter::admin.side_menu.extension'),
                            'permission' => 'Admin.Extensions',
                        ],
                        'updates' => [
                            'priority' => 40,
                            'class' => 'updates',
                            'href' => admin_url('updates'),
                            'title' => lang('igniter::admin.side_menu.updates'),
                            'permission' => 'Site.Updates',
                        ],
                        'system_logs' => [
                            'priority' => 50,
                            'class' => 'system_logs',
                            'href' => admin_url('system_logs'),
                            'title' => lang('igniter::admin.side_menu.system_logs'),
                            'permission' => 'Admin.SystemLogs',
                        ],
                    ],
                ],
            ]);
        });
    }
}
