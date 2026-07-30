<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Listeners;

use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Listeners\MaxGuestSizePerTimeslotReached;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Support\Carbon;

beforeEach(function(): void {
    (new MaxGuestSizePerTimeslotReached)->clearInternalCache();
});

it('returns null when guest limit setting is disabled', function(): void {
    $timeslot = new Carbon('2023-12-01 18:00:00');
    $this->travelTo($timeslot);
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'limit_guests' => 0,
        ],
    ]);
    LocationFacade::setModel($location);

    expect((new MaxGuestSizePerTimeslotReached)->handle($timeslot, 5))->toBeNull();
});

it('returns null when guest limit count is zero', function(): void {
    $timeslot = new Carbon('2023-12-01 18:00:00');
    $this->travelTo($timeslot);
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'limit_guests' => 1,
            'limit_guests_count' => 0,
        ],
    ]);
    LocationFacade::setModel($location);

    expect((new MaxGuestSizePerTimeslotReached)->handle($timeslot, 5))->toBeNull();
});

it('returns null when guest limit is not exceeded', function(): void {
    $timeslot = new Carbon('2023-12-01 18:00:00');
    $this->travelTo($timeslot);
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'limit_guests' => 1,
            'limit_guests_count' => 20,
        ],
    ]);
    LocationFacade::setModel($location);

    Reservation::factory()->create([
        'location_id' => 1,
        'reserve_date' => '2023-12-01',
        'reserve_time' => '18:00',
        'guest_num' => 10,
    ]);

    expect((new MaxGuestSizePerTimeslotReached)->handle($timeslot, 5))->toBeNull();
});

it('returns true when guest limit is exceeded', function(): void {
    $timeslot = new Carbon('2023-12-01 18:00:00');
    $this->travelTo($timeslot);
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => [
            'auto_allocate_table' => 0,
            'limit_guests' => 1,
            'limit_guests_count' => 5,
        ],
    ]);
    LocationFacade::setModel($location);

    Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => '2023-12-01',
        'reserve_time' => '18:00',
        'guest_num' => 5,
    ]);

    $listener = new MaxGuestSizePerTimeslotReached;
    expect($listener->handle($timeslot, 5))->toBeTrue()
        ->and($listener->handle($timeslot, 5))->toBeTrue(); // test cache result
});
