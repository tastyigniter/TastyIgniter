<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests;

use Igniter\Admin\Widgets\Form;
use Igniter\Automation\AutomationRules\Actions\AssignToGroup;
use Igniter\Automation\AutomationRules\Actions\SendMailTemplate;
use Igniter\Automation\AutomationRules\Events\OrderSchedule;
use Igniter\Automation\AutomationRules\Events\ReservationSchedule;
use Igniter\Automation\Classes\BaseAction;
use Igniter\Automation\Classes\BaseEvent;
use Igniter\Automation\Classes\EventManager;
use Igniter\Automation\Console\Cleanup;
use Igniter\Automation\Extension;
use Igniter\Automation\Http\Controllers\Automations;
use Igniter\Automation\Models\RuleAction;
use Igniter\Automation\Tests\Fixtures\TestAction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Mockery;

it('registers event manager singleton and automation cleanup console command', function(): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('singleton')->with(EventManager::class)->once();
    $app->shouldReceive('singleton')->with('command.automation.cleanup', Cleanup::class)->once();
    $app->shouldReceive('make')->andReturn(new Cleanup);

    (new Extension($app))->register();
});

it('extends action form fields on boot', function(): void {
    $app = Mockery::mock(Application::class);
    $form = new class extends Form
    {
        public function __construct() {}

        public function getController(): Automations
        {
            return new Automations;
        }
    };
    $form->model = new RuleAction;
    $form->model->applyActionClass(TestAction::class);
    Event::shouldReceive('listen')->with('admin.form.extendFieldsBefore', Mockery::on(function($callback) use ($form): true {
        $callback($form);

        return true;
    }))->once();
    Event::shouldReceive('listen')->with('automation.order.schedule.hourly', Mockery::any());
    Event::shouldReceive('listen')->with('automation.reservation.schedule.hourly', Mockery::any());
    Event::shouldReceive('listen');

    (new Extension($app))->boot();
});

it('registers scheduled tasks', function(): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('singleton');

    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('call')->with(Mockery::on(function($callback): true {
        $callback();

        return true;
    }))->andReturnSelf();
    $schedule->shouldReceive('name')->with('automation-order-schedule')->andReturnSelf()->once();
    $schedule->shouldReceive('name')->with('automation-reservation-schedule')->andReturnSelf()->once();
    $schedule->shouldReceive('name')->with('Automation Log Cleanup')->andReturnSelf()->once();
    $schedule->shouldReceive('withoutOverlapping')->with(5)->andReturnSelf()->atMost(2);
    $schedule->shouldReceive('runInBackground')->andReturnSelf()->atMost(2);
    $schedule->shouldReceive('hourly')->andReturnSelf()->atMost(2);
    $schedule->shouldReceive('command')->with('automation:cleanup')->andReturnSelf();
    $schedule->shouldReceive('daily')->andReturnSelf()->once();

    (new Extension($app))->registerSchedule($schedule);
});

it('registers permissions with correct attributes', function(): void {
    $app = Mockery::mock(Application::class);
    $permissions = (new Extension($app))->registerPermissions();

    expect($permissions)->toHaveKey('Igniter.Automation.Manage')
        ->and($permissions['Igniter.Automation.Manage']['description'])->toBe('Create, modify and delete automations')
        ->and($permissions['Igniter.Automation.Manage']['group'])->toBe('igniter::admin.permissions.name');
});

it('registers navigation with correct attributes', function(): void {
    $app = Mockery::mock(Application::class);
    $navigation = (new Extension($app))->registerNavigation();

    expect($navigation)->toHaveKey('tools')
        ->and($navigation['tools']['child'])->toHaveKey('automation')
        ->and($navigation['tools']['child']['automation']['priority'])->toBe(5)
        ->and($navigation['tools']['child']['automation']['class'])->toBe('automation')
        ->and($navigation['tools']['child']['automation']['href'])->toBe(admin_url('igniter/automation/automations'))
        ->and($navigation['tools']['child']['automation']['title'])->toBe(lang('igniter.automation::default.text_title'))
        ->and($navigation['tools']['child']['automation']['permission'])->toBe('Igniter.Automation.*');
});

it('loads registered automation events', function(): void {
    $events = BaseEvent::findEvents();

    expect($events)->toHaveKeys([
        OrderSchedule::class,
        ReservationSchedule::class,
    ]);
});

it('loads registered automation actions', function(): void {
    $actions = BaseAction::findActions();

    expect($actions)->toHaveKeys([
        AssignToGroup::class,
        SendMailTemplate::class,
    ]);
});
