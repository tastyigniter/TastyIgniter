<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\System\Http\Requests\AdvancedSettingsRequest;
use Igniter\System\Http\Requests\GeneralSettingsRequest;
use Igniter\System\Http\Requests\MailSettingsRequest;
use Igniter\System\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Override;

class FormServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        Settings::registerCallback(function(Settings $manager) {
            $manager->registerSettingItems('core', [
                'general' => [
                    'label' => 'igniter::system.settings.text_tab_general',
                    'description' => 'igniter::system.settings.text_tab_desc_general',
                    'icon' => 'fa fa-sliders',
                    'priority' => 0,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/general'),
                    'form' => 'generalsettings',
                    'request' => GeneralSettingsRequest::class,
                ],
                'mail' => [
                    'label' => 'lang:igniter::system.settings.text_tab_mail',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_mail',
                    'icon' => 'fa fa-envelope',
                    'priority' => 40,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/mail'),
                    'form' => 'mailsettings',
                    'request' => MailSettingsRequest::class,
                ],
                'statuses' => [
                    'label' => 'lang:igniter::admin.side_menu.status',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_status',
                    'icon' => 'fa fa-diagram-project',
                    'priority' => 45,
                    'class' => 'statuses',
                    'permission' => ['Admin.Statuses'],
                    'url' => admin_url('statuses'),
                ],
                'languages' => [
                    'label' => 'lang:igniter::system.settings.text_tab_language',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_language',
                    'icon' => 'fa fa-language',
                    'priority' => 50,
                    'permission' => ['Site.Languages'],
                    'url' => admin_url('languages'),
                ],
                'countries' => [
                    'label' => 'lang:igniter::system.settings.text_tab_country',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_country',
                    'icon' => 'fa fa-flag',
                    'priority' => 60,
                    'permission' => ['Site.Countries'],
                    'url' => admin_url('countries'),
                ],
                'currencies' => [
                    'label' => 'lang:igniter::system.settings.text_tab_currency',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_currency',
                    'icon' => 'fa fa-money',
                    'priority' => 70,
                    'permission' => ['Site.Currencies'],
                    'url' => admin_url('currencies'),
                ],
                'advanced' => [
                    'label' => 'lang:igniter::system.settings.text_tab_server',
                    'description' => 'lang:igniter::system.settings.text_tab_desc_server',
                    'icon' => 'fa fa-cog',
                    'priority' => 999,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/advanced'),
                    'form' => 'advancedsettings',
                    'request' => AdvancedSettingsRequest::class,
                ],
            ]);
        });
    }
}
