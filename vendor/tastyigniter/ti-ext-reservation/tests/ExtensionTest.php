<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\Http\Controllers\Dashboard;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Database\Model;
use Igniter\Reservation\AutomationRules\Conditions\ReservationAttribute;
use Igniter\Reservation\AutomationRules\Conditions\ReservationStatusAttribute;
use Igniter\Reservation\BulkActionWidgets\AssignTable;
use Igniter\Reservation\Extension;
use Igniter\Reservation\FormWidgets\FloorPlanner;
use Igniter\Reservation\Http\Requests\BookingSettingsRequest;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\System\Models\Settings;
use Igniter\User\Http\Controllers\Customers;
use Igniter\User\Models\Customer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Mockery;

beforeEach(function(): void {
    $this->extension = new Extension(app());
});

it('returns correct dining section class', function(): void {
    $this->extension->boot();

    $morphMap = Relation::morphMap();

    expect($morphMap['dining_sections'])->toBe(DiningSection::class);
});

it('binds reservation event correctly', function(): void {
    Event::shouldReceive('listen')->with('admin.statusHistory.beforeAddStatus', Mockery::any())->once();
    Event::shouldReceive('listen')->with('admin.statusHistory.added', Mockery::any())->once();
    Event::shouldReceive('listen')->with('admin.assignable.assigned', Mockery::any())->once();
    Event::shouldReceive('listen')->with('admin.form.extendFields', Mockery::any())->once();
    Event::shouldReceive('listen')->with('igniter.reservation.statusAdded', Mockery::any())->once();

    $this->extension->boot();
});

it('registers correct mail templates', function(): void {
    $mailTemplates = $this->extension->registerMailTemplates();

    expect($mailTemplates)->toHaveKey('igniter.reservation::mail.reservation')
        ->and($mailTemplates)->toHaveKey('igniter.reservation::mail.reservation_alert')
        ->and($mailTemplates)->toHaveKey('igniter.reservation::mail.reservation_update');
});

it('registers correct automation rules', function(): void {
    $automationRules = $this->extension->registerAutomationRules();

    expect($automationRules['events'])->toHaveKey('igniter.reservation.confirmed')
        ->and($automationRules['events'])->toHaveKey('igniter.reservation.statusAdded')
        ->and($automationRules['events'])->toHaveKey('igniter.reservation.assigned')
        ->and($automationRules['conditions'])->toContain(ReservationAttribute::class)
        ->and($automationRules['conditions'])->toContain(ReservationStatusAttribute::class);
});

it('registers correct permissions', function(): void {
    $permissions = $this->extension->registerPermissions();

    expect($permissions)->toHaveKey('Admin.Tables')
        ->and($permissions)->toHaveKey('Admin.Reservations')
        ->and($permissions)->toHaveKey('Admin.DeleteReservations')
        ->and($permissions)->toHaveKey('Admin.AssignReservations')
        ->and($permissions)->toHaveKey('Admin.AssignReservationTables');
});

it('registers correct navigation items', function(): void {
    $navigation = $this->extension->registerNavigation();

    expect($navigation)->toHaveKey('reservations')
        ->and($navigation['reservations']['href'])->toBe(admin_url('reservations'))
        ->and($navigation['restaurant']['child'])->toHaveKey('dining_areas')
        ->and($navigation['restaurant']['child']['dining_areas']['href'])->toBe(admin_url('dining_areas'));
});

it('registers correct form widgets', function(): void {
    $formWidgets = $this->extension->registerFormWidgets();

    expect($formWidgets)->toHaveKey(FloorPlanner::class)
        ->and($formWidgets[FloorPlanner::class]['code'])->toBe('floorplanner');
});

it('registers correct list action widgets', function(): void {
    $listActionWidgets = $this->extension->registerListActionWidgets();

    expect($listActionWidgets)->toHaveKey(AssignTable::class)
        ->and($listActionWidgets[AssignTable::class]['code'])->toBe('assign_table');
});

it('registers correct location settings', function(): void {
    $locationSettings = $this->extension->registerLocationSettings();

    expect($locationSettings)->toHaveKey('booking')
        ->and($locationSettings['booking']['form'])->toBe('igniter.reservation::/models/bookingsettings')
        ->and($locationSettings['booking']['request'])->toBe(BookingSettingsRequest::class);
});

it('does not add reservations tab to customer edit form when model is invalid', function(): void {
    $model = mock(Model::class)->makePartial();
    $form = new Form(resolve(Customers::class), ['model' => $model, 'context' => 'edit']);
    $form->bindToController();

    $fields = $form->getFields();

    expect($fields)->not->toHaveKey('reservations');
});

it('adds reservations tab to customer edit form', function(): void {
    $customer = mock(Customer::class)->makePartial();
    $form = new Form(resolve(Customers::class), ['model' => $customer, 'context' => 'edit']);
    $form->bindToController();

    $fields = $form->getFields();

    expect($fields['reservations']->tab)->toBe('lang:igniter.reservation::default.text_tab_reservations');
});

it('sends reservation update after status is updated', function(): void {
    Mail::fake();
    $reservation = Reservation::factory()->create();
    $statusHistory = StatusHistory::factory()->create([
        'object_id' => $reservation->getKey(),
        'object_type' => 'reservations',
        'notify' => true,
    ]);

    event('igniter.reservation.statusAdded', [$reservation, $statusHistory]);

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mail): bool => $mail->getTemplateCode() === 'igniter.reservation::mail.reservation_update');
});

it('returns registered dashboard charts', function(): void {
    $charts = new class(resolve(Dashboard::class)) extends Charts
    {
        public function testDatasets()
        {
            return $this->listSets();
        }
    };
    $datasets = $charts->testDatasets();

    expect($datasets['reports']['sets']['reservations']['model'])->toBe(Reservation::class);
});

it('returns registered dashboard statistic widgets', function(): void {
    $statistics = new class(resolve(Dashboard::class)) extends Statistics
    {
        public function testCards(): array
        {
            return $this->listCards();
        }
    };
    $cards = $statistics->testCards();

    expect(array_keys($cards))->toContain(
        'reserved_table',
        'reserved_guest',
        'reservation',
        'completed_reservation',
    );
});

it('returns registered core settings', function(): void {
    $items = (new Settings)->listSettingItems();

    expect(collect($items['core'])->firstWhere('code', 'reservation'))->not->toBeNull();
});
