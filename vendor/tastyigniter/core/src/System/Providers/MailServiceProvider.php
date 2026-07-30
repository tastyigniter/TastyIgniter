<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Classes\MailManager;
use Igniter\System\Http\Controllers\Settings;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Override;

class MailServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        resolve(MailManager::class)->registerCallback(function(MailManager $manager) {
            $manager->registerMailLayouts([
                'default' => 'igniter.system::_mail.layouts.default',
            ]);

            $manager->registerMailPartials([
                'header' => 'igniter.system::_mail.partials.header',
                'footer' => 'igniter.system::_mail.partials.footer',
                'button' => 'igniter.system::_mail.partials.button',
                'panel' => 'igniter.system::_mail.partials.panel',
                'table' => 'igniter.system::_mail.partials.table',
                'subcopy' => 'igniter.system::_mail.partials.subcopy',
                'promotion' => 'igniter.system::_mail.partials.promotion',
            ]);

            $manager->registerMailVariables(
                File::getRequire(File::symbolizePath('igniter::models/system/mailvariables.php')),
            );
        });
    }

    public function boot(): void
    {
        Igniter::useMailerConfigFile();

        Event::listen('mailer.beforeRegister', function() {
            if (!Igniter::usingMailerConfigFile()) {
                resolve(MailManager::class)->applyMailerConfigValues();
            }
        });

        Event::listen('admin.form.extendFieldsBefore', function(Form $widget) {
            if ($widget->getController() instanceof Settings
                && $widget->getController()->settingCode === 'mail'
                && Igniter::usingMailerConfigFile()
            ) {
                $widget->fields = array_prepend($widget->fields, [
                    'label' => sprintf(lang('igniter::system.settings.help_use_mailer_config_file'),
                        'https://tastyigniter.com/docs/advanced/mail#configuration',
                    ),
                    'type' => 'section',
                ], 'use_config_file');
            }
        });
    }
}
