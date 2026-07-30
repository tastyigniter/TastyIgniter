<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\BulkActionWidget;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Classes\ToolbarButton;
use Igniter\Local\Models\Location;
use Igniter\Reservation\BulkActionWidgets\AssignTable;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Reservation;

it('assigns tables to reservations without tables', function(): void {
    $controller = new class extends AdminController {};
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'auto_allocate_table' => 0,
        ],
    ]);
    DiningTable::factory()
        ->count(2)
        ->for(DiningArea::factory()->for($location, 'location')->create(), 'dining_area')
        ->create([
            'min_capacity' => 40,
            'max_capacity' => 60,
            'priority' => 1,
            'is_enabled' => true,
        ]);
    $reservations = Reservation::factory()->count(2)->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    (new AssignTable($controller, new ToolbarButton('assign_table')))->handleAction([], $reservations);

    expect(flash()->messages()->first())->message->not->toBeNull()->level->toBe('success');
});

it('does not assign tables to reservations with existing tables', function(): void {
    $controller = new class extends AdminController {};
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'auto_allocate_table' => 0,
        ],
    ]);
    $diningTable = DiningTable::factory()
        ->for(DiningArea::factory()->for($location, 'location')->create(), 'dining_area')
        ->create([
            'min_capacity' => 40,
            'max_capacity' => 60,
            'priority' => 1,
        ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);
    $reservation->tables()->attach($diningTable);
    $records = collect([$reservation]);

    (new AssignTable($controller, new ToolbarButton('assign_table')))->handleAction([], $records);

    expect(flash()->messages()->isEmpty())->toBeTrue();
});

it('shows warning if no tables can be assigned', function(): void {
    $controller = new class extends AdminController {};
    $location = Location::factory()->create();
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    $records = collect([$reservation]);

    (new AssignTable($controller, new ToolbarButton('assign_table')))->handleAction([], $records);

    expect(flash()->messages()->first())
        ->message->not->toBeNull()
        ->level->toBe('warning');
});

it('assigns tables to reservations in correct order', function(): void {
    $controller = new class extends AdminController {};
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'auto_allocate_table' => 0,
        ],
    ]);
    DiningTable::factory()
        ->count(2)
        ->for(DiningArea::factory()->for($location, 'location')->create(), 'dining_area')
        ->create([
            'min_capacity' => 40,
            'max_capacity' => 60,
            'priority' => 1,
            'is_enabled' => true,
        ]);
    $reservations = Reservation::factory()->count(2)->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    (new AssignTable($controller, new ToolbarButton('assign_table')))->handleAction([], $reservations);

    expect(flash()->messages()->first())->message->not->toBeNull()->level->toBe('success');
});
