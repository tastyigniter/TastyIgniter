<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models;

use Carbon\Carbon;
use Igniter\Admin\Models\Concerns\GeneratesHash;
use Igniter\Admin\Models\Concerns\LogsStatusHistory;
use Igniter\Admin\Models\Status;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Events\ReservationCanceledEvent;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\Event;
use Mockery;

it('returns correct customer name', function(): void {
    $reservation = new Reservation([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    expect($reservation->customer_name)->toBe('John Doe');
});

it('calculates correct reservation end time with duration', function(): void {
    $reservation = new Reservation([
        'reserve_date' => '2023-10-10',
        'reserve_time' => '12:00:00',
    ]);
    $reservation->duration = 120;

    expect($reservation->reservation_end_datetime->toDateTimeString())->toBe('2023-10-10 14:00:00');
});

it('calculates correct reservation end time without duration', function(): void {
    $reservation = new Reservation([
        'reserve_date' => '2023-10-10',
        'reserve_time' => '12:00:00',
    ]);

    expect($reservation->reservation_end_datetime->toDateTimeString())->toBe('2023-10-10 23:59:59');
});

it('returns null reservation end time when missing date time', function(): void {
    $reservation = new Reservation([
        'reserve_date' => null,
        'reserve_time' => null,
    ]);

    expect($reservation->reservation_end_datetime)->toBeNull();
});

it('returns correct table name when tables are assigned', function(): void {
    $table1 = Mockery::mock(DiningTable::class)->makePartial();
    $table2 = Mockery::mock(DiningTable::class)->makePartial();
    $table1->name = 'Table1';
    $table1->min_capacity = 2;
    $table1->max_capacity = 4;
    $table1->extra_capacity = 0;
    $table2->name = 'Table2';
    $table2->min_capacity = 4;
    $table2->max_capacity = 8;
    $table2->extra_capacity = 2;

    $reservation = new Reservation;
    $reservation->setRelation('tables', collect([$table1, $table2]));

    expect($reservation->table_name)->toBe('Table1 / 2 - 4 (0+), Table2 / 4 - 8 (2+)');
});

it('returns empty table name when no tables are assigned', function(): void {
    $reservation = new Reservation;
    $reservation->setRelation('tables', collect());

    expect($reservation->table_name)->toBe('');
});

it('sets location stay time as default duration when null', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['stay_time' => 120],
    ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
    ]);

    $reservation->duration = null;

    expect($reservation->duration)->toBe(120);
});

it('returns correct occasion attribute', function(): void {
    $reservation = new Reservation;
    $reservation->occasion_id = 1;

    expect($reservation->occasion)->toBe('birthday');
});

it('returns true if reservation is completed', function(): void {
    $reservation = Reservation::factory()->create();
    $reservation->addStatusHistory(setting('confirmed_reservation_status'));

    $result = $reservation->isCompleted();

    expect($result)->toBeTrue();
});

it('returns true if reservation is canceled', function(): void {
    $reservation = Reservation::factory()->create();
    $reservation->addStatusHistory(setting('canceled_reservation_status'));

    $result = $reservation->isCanceled();

    expect($result)->toBeTrue();
});

it('returns true if reservation is cancelable', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['cancellation_timeout' => 60],
    ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->addDay(),
        'reserve_time' => now()->addDay()->toTimeString(),
    ]);

    $result = $reservation->isCancelable();

    expect($result)->toBeTrue();
});

it('returns false if reservation is not cancelable due to timeout', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['cancellation_timeout' => 0],
    ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->addMinutes(30),
        'reserve_time' => now()->addMinutes(30)->toTimeString(),
    ]);

    $result = $reservation->isCancelable();

    expect($result)->toBeFalse();
});

it('returns false if reservation is not cancelable due to past date', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['cancellation_timeout' => 60],
    ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->subDay(),
        'reserve_time' => now()->subDay()->toTimeString(),
    ]);

    $result = $reservation->isCancelable();

    expect($result)->toBeFalse();
});

it('marks reservation as canceled and dispatches event', function(): void {
    Event::fake();
    $reservation = Reservation::factory()->create(['status_id' => 1]);

    $result = $reservation->markAsCanceled();

    expect($result)->toBeTrue()
        ->and($reservation->fresh()->status_id)->toBe((int)setting('canceled_reservation_status'));

    Event::assertDispatched(ReservationCanceledEvent::class);
});

it('finds reserved tables for a given location and datetime', function(): void {
    $location = Location::factory()->create();
    $diningArea = DiningArea::factory()->create(['location_id' => $location->getKey()]);
    $table = DiningTable::factory()->for($diningArea, 'dining_area')->create();
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'duration' => 120,
        'status_id' => setting('confirmed_reservation_status'),
    ]);
    $reservation->tables()->attach($table);

    $result = Reservation::findReservedTables($location->getKey(), now()->toDateTimeString());

    expect($result->keys()->all())->toContain($table->getKey());
});

it('returns correct reservation dates', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('pluckDates')->with('reserve_date')->andReturn(['2023-10-10', '2023-10-11']);

    expect($reservation->getReservationDates())->toBe(['2023-10-10', '2023-10-11']);
});

it('adds reservation tables correctly', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->exists = true;
    $reservation->shouldReceive('tables->sync')->with([1, 2, 3])->once();

    expect($reservation->addReservationTables([1, 2, 3]))->toBeTrue();
});

it('does not add reservation tables when reservation does not exist', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('exists')->andReturn(false);

    expect($reservation->addReservationTables([1, 2, 3]))->toBeFalse();
});

it('returns false when no available table to assign', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['auto_allocate_table' => 0],
    ]);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    $result = $reservation->autoAssignTable();

    expect($result)->toBeFalse();
});

it('returns the next bookable table when available', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['auto_allocate_table' => 1],
    ]);
    $diningArea = DiningArea::factory()->for($location, 'location')->create();
    $attributes = [
        'min_capacity' => 40,
        'max_capacity' => 60,
        'priority' => 1,
    ];
    $diningTable1 = DiningTable::factory()->for($diningArea, 'dining_area')->create($attributes);
    $diningTable2 = DiningTable::factory()->for($diningArea, 'dining_area')->create($attributes);
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    $result = $reservation->getNextBookableTable();

    expect($result->first())->toBeInstanceOf(DiningTable::class)
        ->and(collect([$diningTable1, $diningTable2])->pluck('id')->all())->toContain($result->first()->getKey());
});

it('returns the next bookable sectioned table when available', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'booking',
        'data' => ['auto_allocate_table' => 1],
    ]);
    $diningArea = DiningArea::factory()->for($location, 'location')->create();
    $diningSection = DiningSection::factory()->for($location, 'location')->create();
    $attributes = [
        'min_capacity' => 40,
        'max_capacity' => 60,
        'priority' => 1,
    ];
    $diningTable1 = DiningTable::factory()->for($diningArea, 'dining_area')->create($attributes);
    $diningTable2 = DiningTable::factory()->for($diningArea, 'dining_area')->create($attributes);
    $diningTable1->dining_section()->associate($diningSection)->save();
    $diningTable2->dining_section()->associate($diningSection)->save();
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 50,
        'duration' => 120,
        'status_id' => 1,
    ]);

    $result = $reservation->getNextBookableTable();

    expect($result->first())->toBeInstanceOf(DiningTable::class)
        ->and(collect([$diningTable1, $diningTable2])->pluck('id')->all())->toContain($result->first()->getKey());
});

it('returns empty dining tables if location is not set', function(): void {
    $reservation = Reservation::factory()->create(['location_id' => '']);

    $result = $reservation->getDiningTableOptions();

    expect($result)->toBeArray()
        ->and($result)->toBeEmpty();
});

it('returns dining table options for the given location', function(): void {
    $location = Location::factory()->create();
    $location = Location::factory()->create();

    $diningArea = DiningArea::factory()->create(['location_id' => $location->getKey()]);
    $diningTables = DiningTable::factory()->count(2)->for($diningArea, 'dining_area')->create();
    $reservation = Reservation::factory()->for($location, 'location')->create();

    $result = $reservation->getDiningTableOptions()->all();

    expect($result)->toBeArray()
        ->and($result)->toContain(...$diningTables->pluck('name')->all());
});

it('gets mail recipients correctly for customer type', function(): void {
    $reservation = Reservation::factory()->create([
        'email' => 'customer@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    setting()->set(['reservation_email' => ['customer']]);

    $recipients = $reservation->mailGetRecipients('customer');

    expect($recipients)->toBe([[$reservation->email, $reservation->customer_name]]);
});

it('gets mail recipients correctly for location type', function(): void {
    $location = Location::factory()->create();
    $reservation = Reservation::factory()->for($location)->create();

    setting()->set(['reservation_email' => ['location']]);

    $recipients = $reservation->mailGetRecipients('location');

    expect($recipients)->toBe([[$location->location_email, $location->location_name]]);
});

it('gets mail recipients correctly for admin type', function(): void {
    $reservation = Reservation::factory()->create();

    setting()->set([
        'site_email' => 'site@example.com',
        'site_name' => 'Site',
        'reservation_email' => ['admin'],
    ]);

    $recipients = $reservation->mailGetRecipients('admin');

    expect($recipients)->toBe([[setting('site_email'), setting('site_name')]]);
});

it('gets mail reply to correctly for admin type', function(): void {
    $reservation = Reservation::factory()->create();

    setting()->set([
        'site_email' => 'site@example.com',
        'site_name' => 'Site',
        'reservation_email' => ['admin', 'location'],
    ]);

    $recipients = $reservation->mailGetReplyTo('admin');

    expect($recipients)->toBe([setting('site_email'), setting('site_name')]);

    $recipients = $reservation->mailGetReplyTo('location');

    expect($recipients)->toBe([$reservation->location->location_email, $reservation->location->location_name]);
});

it('returns empty reply to array when type is not in reservation email settings', function(): void {
    $reservation = Reservation::factory()->create();

    setting()->set(['reservation_email' => 'invalid']);

    $recipients = $reservation->mailGetReplyTo('admin');

    expect($recipients)->toBeArray()->toBeEmpty();
});

it('returns empty recipient array when type is not in reservation email settings', function(): void {
    $reservation = Reservation::factory()->create();

    setting()->set(['reservation_email' => 'invalid']);

    $recipients = $reservation->mailGetRecipients('admin');

    expect($recipients)->toBeArray()->toBeEmpty();
});

it('returns correct mail data for reservation', function(): void {
    $location = Location::factory()->create();
    $reservation = Reservation::factory()->create([
        'location_id' => $location->getKey(),
        'reserve_date' => now()->toDateString(),
        'reserve_time' => now()->toTimeString(),
        'guest_num' => 4,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'telephone' => '1234567890',
        'comment' => 'Test comment',
    ]);

    $data = $reservation->mailGetData();

    expect($data['reservation_number'])->toBe($reservation->reservation_id)
        ->and($data['reservation_time'])->toBe(Carbon::createFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.time_format')))
        ->and($data['reservation_date'])->toBe($reservation->reserve_date->isoFormat(lang('system::lang.moment.date_format_long')))
        ->and($data['reservation_guest_no'])->toBe($reservation->guest_num)
        ->and($data['first_name'])->toBe($reservation->first_name)
        ->and($data['last_name'])->toBe($reservation->last_name)
        ->and($data['email'])->toBe($reservation->email)
        ->and($data['telephone'])->toBe($reservation->telephone)
        ->and($data['reservation_comment'])->toBe($reservation->comment)
        ->and($data['location_name'])->toBe($location->location_name)
        ->and($data['location_email'])->toBe($location->location_email)
        ->and($data['location_telephone'])->toBe($location->location_telephone);
});

it('applies filters to query builder', function(): void {
    $query = Reservation::query()->applyFilters([
        'status' => 'confirmed',
        'location' => 1,
        'dateTimeFilter' => '2023-10-10 12:00:00',
        'search' => 'John Doe',
    ]);

    expect($query->toSql())
        ->toContain('`status_id` in (?)')
        ->toContain('`location_id` in (?)')
        ->toContain('ADDTIME(reserve_date, reserve_time) between ? and ?')
        ->toContain('lower(first_name) like ?', 'lower(last_name) like ?');
});

it('returns correct event details', function(): void {
    $location = Location::factory()->create();
    $reservation = Reservation::factory()->for($location, 'location')->create([
        'guest_num' => 4,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'telephone' => '1234567890',
        'reserve_date' => '2023-10-10',
        'reserve_time' => '12:00:00',
        'duration' => 120,
    ]);

    $status = Status::factory()->create(['status_color' => 'red']);
    $reservation->status()->associate($status)->save();
    $reservation->tables()->saveMany([
        $diningTable = DiningTable::factory()->create(['name' => 'Table1']),
    ]);

    $expectedDetails = [
        'id' => $reservation->getKey(),
        'title' => sprintf('Table1 / %s - %s (%s+) (4)',
            $diningTable->min_capacity,
            $diningTable->max_capacity,
            $diningTable->extra_capacity,
        ),
        'start' => '2023-10-10T12:00:00+01:00',
        'end' => '2023-10-10T14:00:00+01:00',
        'allDay' => false,
        'color' => 'red',
        'location_name' => $location->location_name,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'telephone' => '1234567890',
        'guest_num' => 4,
        'reserve_date' => '2023-10-10',
        'reserve_time' => '12:00:00',
        'reserve_end_time' => '14:00:00',
        'duration' => 120,
        'status' => [
            'status_name' => $status->status_name,
            'status_for' => $status->status_for,
            'status_color' => 'red',
            'status_comment' => $status->status_comment,
            'notify_customer' => $status->notify_customer,
            'updated_at' => $status->updated_at->toJson(),
            'created_at' => $status->created_at->toJson(),
            'status_id' => $status->getKey(),
        ],
        'tables' => [
            [
                'id' => $diningTable->getKey(),
                'dining_area_id' => 0,
                'dining_section_id' => null,
                'parent_id' => null,
                'name' => 'Table1',
                'shape' => null,
                'min_capacity' => $diningTable->min_capacity,
                'max_capacity' => $diningTable->max_capacity,
                'extra_capacity' => 0,
                'is_combo' => false,
                'is_enabled' => $diningTable->is_enabled,
                'nest_left' => 29,
                'nest_right' => 30,
                'priority' => $diningTable->priority,
                'seat_layout' => null,
                'created_at' => $diningTable->created_at->toJson(),
                'updated_at' => $diningTable->updated_at->toJson(),
                'pivot' => [
                    'reservation_id' => $reservation->getKey(),
                    'dining_table_id' => $diningTable->getKey(),
                ],
            ],
        ],
    ];

    expect($reservation->getEventDetails())->toBe($expectedDetails);
});

it('assigns staff to reservation', function(): void {
    Event::fake(['igniter.reservation.assigned']);
    $assigneeGroup = UserGroup::factory()->create();
    $assignee = User::factory()->create();
    $user = User::factory()->create();
    $reservation = Reservation::factory()->create();
    $reservation->assignee_group()->associate($assigneeGroup)->save();

    $assignableLog = $reservation->assignTo($assignee, $user);

    expect($assignableLog->assignable_id)->toBe($reservation->getKey())
        ->and($assignableLog->assignee_id)->toBe($assignee->getKey())
        ->and($assignableLog->user_id)->toBe($user->getKey());

    Event::assertDispatched('igniter.reservation.assigned');
});

it('configures reservation model correctly', function(): void {
    $reservation = new Reservation;

    expect(class_uses_recursive($reservation))
        ->toContain(Assignable::class)
        ->toContain(GeneratesHash::class)
        ->toContain(Locationable::class)
        ->toContain(LogsStatusHistory::class)
        ->toContain(Purgeable::class)
        ->toContain(SendsMailTemplate::class)
        ->and($reservation->getTable())->toBe('reservations')
        ->and($reservation->getKeyName())->toBe('reservation_id')
        ->and($reservation->timestamps)->toBeTrue()
        ->and($reservation->getDateFormat())->toBe('Y-m-d')
        ->and($reservation->getTimeFormat())->toBe('H:i')
        ->and($reservation->getGuarded())->toBe(['ip_address', 'user_agent', 'hash'])
        ->and($reservation->getCasts())->toHaveKeys([
            'location_id', 'table_id', 'guest_num',
            'occasion_id', 'assignee_id', 'reserve_time',
            'reserve_date', 'notify', 'duration', 'processed',
        ])
        ->and($reservation->relation['belongsTo']['customer'])->toBe(Customer::class)
        ->and($reservation->relation['belongsTo']['location'])->toBe(Location::class)
        ->and($reservation->relation['belongsToMany']['tables'])->toBe([
            DiningTable::class, 'table' => 'reservation_tables',
        ])
        ->and($reservation->getAppends())->toContain('customer_name', 'duration', 'table_name', 'reservation_datetime', 'reservation_end_datetime')
        ->and($reservation->getPurgeableAttributes())->toBe(['tables']);
});
