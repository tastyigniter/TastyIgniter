<?php

declare(strict_types=1);

namespace Igniter\Admin\Providers;

use Igniter\Admin\BulkActionWidgets\Delete;
use Igniter\Admin\BulkActionWidgets\Status;
use Igniter\Admin\Classes\OnboardingSteps;
use Igniter\Admin\Classes\Widgets;
use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Onboarding;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\FormWidgets\CodeEditor;
use Igniter\Admin\FormWidgets\ColorPicker;
use Igniter\Admin\FormWidgets\Connector;
use Igniter\Admin\FormWidgets\DataTable;
use Igniter\Admin\FormWidgets\DatePicker;
use Igniter\Admin\FormWidgets\MarkdownEditor;
use Igniter\Admin\FormWidgets\RecordEditor;
use Igniter\Admin\FormWidgets\Relation;
use Igniter\Admin\FormWidgets\Repeater;
use Igniter\Admin\FormWidgets\RichEditor;
use Igniter\Admin\FormWidgets\StatusEditor;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Models\Theme;
use Igniter\System\DashboardWidgets\Cache;
use Igniter\System\DashboardWidgets\News;
use Igniter\System\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Override;

class FormServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        if (Igniter::runningInAdmin() || app()->runningUnitTests()) {
            $this->registerDashboardWidgets();
            $this->registerBulkActionWidgets();
            $this->registerFormWidgets();
            $this->registerOnboardingSteps();
        }
    }

    /*
     * Register dashboard widgets
     */
    protected function registerDashboardWidgets()
    {
        resolve(Widgets::class)->registerDashboardWidgets(function(Widgets $manager) {
            $manager->registerDashboardWidget(Cache::class, [
                'code' => 'cache',
                'label' => 'Cache Usage',
            ]);

            $manager->registerDashboardWidget(News::class, [
                'code' => 'news',
                'label' => 'Latest News',
            ]);

            $manager->registerDashboardWidget(Statistics::class, [
                'code' => 'stats',
                'label' => 'Statistics widget',
            ]);

            $manager->registerDashboardWidget(Onboarding::class, [
                'code' => 'onboarding',
                'label' => 'Onboarding widget',
            ]);

            $manager->registerDashboardWidget(Charts::class, [
                'code' => 'charts',
                'label' => 'Charts widget',
            ]);
        });
    }

    protected function registerBulkActionWidgets()
    {
        resolve(Widgets::class)->registerBulkActionWidgets(function(Widgets $manager) {
            $manager->registerBulkActionWidget(Status::class, [
                'code' => 'status',
            ]);

            $manager->registerBulkActionWidget(Delete::class, [
                'code' => 'delete',
            ]);
        });
    }

    /**
     * Register widgets
     */
    protected function registerFormWidgets()
    {
        resolve(Widgets::class)->registerFormWidgets(function(Widgets $manager) {
            $manager->registerFormWidget(CodeEditor::class, [
                'label' => 'Code editor',
                'code' => 'codeeditor',
            ]);

            $manager->registerFormWidget(ColorPicker::class, [
                'label' => 'Color picker',
                'code' => 'colorpicker',
            ]);

            $manager->registerFormWidget(Connector::class, [
                'label' => 'Connector',
                'code' => 'connector',
            ]);

            $manager->registerFormWidget(DataTable::class, [
                'label' => 'Data Table',
                'code' => 'datatable',
            ]);

            $manager->registerFormWidget(DatePicker::class, [
                'label' => 'Date picker',
                'code' => 'datepicker',
            ]);

            $manager->registerFormWidget(MarkdownEditor::class, [
                'label' => 'Markdown Editor',
                'code' => 'markdowneditor',
            ]);

            $manager->registerFormWidget(RecordEditor::class, [
                'label' => 'Record Editor',
                'code' => 'recordeditor',
            ]);

            $manager->registerFormWidget(Relation::class, [
                'label' => 'Relationship',
                'code' => 'relation',
            ]);

            $manager->registerFormWidget(Repeater::class, [
                'label' => 'Repeater',
                'code' => 'repeater',
            ]);

            $manager->registerFormWidget(RichEditor::class, [
                'label' => 'Rich editor',
                'code' => 'richeditor',
            ]);

            $manager->registerFormWidget(StatusEditor::class, [
                'label' => 'Status Editor',
                'code' => 'statuseditor',
            ]);
        });
    }

    protected function registerOnboardingSteps()
    {
        OnboardingSteps::registerCallback(function(OnboardingSteps $manager) {
            $manager->registerSteps([
                'admin::settings' => [
                    'label' => 'igniter::admin.dashboard.onboarding.label_settings',
                    'description' => 'igniter::admin.dashboard.onboarding.help_settings',
                    'icon' => 'fa-gears',
                    'url' => admin_url('settings'),
                    'priority' => 10,
                    'complete' => Settings::onboardingIsComplete(...),
                ],
                'admin::themes' => [
                    'label' => 'igniter::admin.dashboard.onboarding.label_themes',
                    'description' => 'igniter::admin.dashboard.onboarding.help_themes',
                    'icon' => 'fa-paint-brush',
                    'url' => admin_url('themes'),
                    'priority' => 40,
                    'complete' => Theme::onboardingIsComplete(...),
                ],
                'admin::mail' => [
                    'label' => 'igniter::admin.dashboard.onboarding.label_mail',
                    'description' => 'igniter::admin.dashboard.onboarding.help_mail',
                    'icon' => 'fa-envelope',
                    'url' => admin_url('settings/edit/mail'),
                    'priority' => 50,
                    'complete' => Settings::onboardingMailIsComplete(...),
                ],
            ]);
        });
    }
}
