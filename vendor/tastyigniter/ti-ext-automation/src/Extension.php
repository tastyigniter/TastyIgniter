<?php

declare(strict_types=1);

namespace Igniter\Automation;

use Igniter\Admin\Widgets\Form;
use Igniter\Automation\AutomationRules\Actions\AssignToGroup;
use Igniter\Automation\AutomationRules\Actions\SendMailTemplate;
use Igniter\Automation\AutomationRules\Events\OrderSchedule;
use Igniter\Automation\AutomationRules\Events\ReservationSchedule;
use Igniter\Automation\Classes\EventManager;
use Igniter\Automation\Console\Cleanup;
use Igniter\Automation\Http\Controllers\Automations;
use Igniter\Automation\Models\AutomationLog;
use Igniter\Automation\Models\RuleAction;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Classes\BaseExtension;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Event;
use Override;

/**
 * Automation Extension Information File
 */
class Extension extends BaseExtension
{
    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->singleton(EventManager::class);

        $this->registerConsoleCommand('automation.cleanup', Cleanup::class);
    }

    #[Override]
    public function boot(): void
    {
        EventManager::bindRules();

        $this->extendActionFormFields();

        Igniter::prunableModel(AutomationLog::class);
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Igniter.Automation.Manage' => [
                'description' => 'Create, modify and delete automations',
                'group' => 'igniter::admin.permissions.name',
            ],
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'tools' => [
                'child' => [
                    'automation' => [
                        'priority' => 5,
                        'class' => 'automation',
                        'href' => admin_url('igniter/automation/automations'),
                        'title' => lang('igniter.automation::default.text_title'),
                        'permission' => 'Igniter.Automation.*',
                    ],
                ],
            ],
        ];
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [
                'automation.order.schedule.hourly' => OrderSchedule::class,
                'automation.reservation.schedule.hourly' => ReservationSchedule::class,
            ],
            'actions' => [
                AssignToGroup::class,
                SendMailTemplate::class,
            ],
            'conditions' => [],
        ];
    }

    /**
     * Registers scheduled tasks that are executed on a regular basis.
     */
    #[Override]
    public function registerSchedule(Schedule $schedule): void
    {
        $schedule->call(function(): void {
            // Pull orders created within the last 30days
            EventManager::fireOrderScheduleEvents();
        })->name('automation-order-schedule')->withoutOverlapping(5)->hourly();

        $schedule->call(function(): void {
            // Pull reservations booked within the last 30days
            EventManager::fireReservationScheduleEvents();
        })->name('automation-reservation-schedule')->withoutOverlapping(5)->hourly();

        $schedule->command('automation:cleanup')->name('Automation Log Cleanup')->daily();
    }

    protected function extendActionFormFields()
    {
        Event::listen('admin.form.extendFieldsBefore', function(Form $form): void {
            if ($form->getController() instanceof Automations && $form->model instanceof RuleAction) {
                $form->arrayName .= '[options]';
                $form->fields = array_get($form->model->getFieldConfig(), 'fields', []);
            }
        });
    }
}
