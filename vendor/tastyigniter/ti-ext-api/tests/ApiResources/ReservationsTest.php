<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Admin\Models\Status;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Laravel\Sanctum\Sanctum;

it('returns all reservations', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    Reservation::factory()->count(3)->create();
    $reservation = Reservation::first();

    $this
        ->get(route('igniter.api.reservations.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$reservation->getKey())
        ->assertJsonPath('data.0.attributes.email', $reservation->email);
});

it('shows a reservation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$reservation->getKey())
        ->assertJsonPath('data.attributes.email', $reservation->email);
});

it('shows a reservation with location relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservation->location()->associate($reservationLocation = Location::factory()->create())->save();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'location']))
        ->assertOk()
        ->assertJsonPath('data.relationships.location.data.type', 'locations')
        ->assertJsonPath('included.0.id', (string)$reservationLocation->getKey())
        ->assertJsonPath('included.0.attributes.location_name', $reservation->location->location_name);
});

it('shows a reservation with tables relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservationTable = $reservation->tables()->create(['name' => 'Table 1']);
    $reservation->refresh();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'tables']))
        ->assertOk()
        ->assertJsonPath('data.relationships.tables.data.0.type', 'tables')
        ->assertJsonPath('included.0.id', (string)$reservationTable->getKey())
        ->assertJsonPath('included.0.attributes.name', 'Table 1');
});

it('shows a reservation with status relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservation->status()->associate($reservationStatus = Status::factory()->create())->save();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'status']))
        ->assertOk()
        ->assertJsonPath('data.relationships.status.data.type', 'statuses')
        ->assertJsonPath('included.0.id', (string)$reservationStatus->getKey())
        ->assertJsonPath('included.0.attributes.status_name', $reservationStatus->status_name);
});

it('shows a reservation with status_history relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservationStatusHistory = $reservation->status_history()->create(['status_id' => 1]);

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'status_history']))
        ->assertOk()
        ->assertJsonPath('data.relationships.status_history.data.0.type', 'status_history')
        ->assertJsonPath('included.0.id', (string)$reservationStatusHistory->getKey())
        ->assertJsonPath('included.0.attributes.status_id', 1);
});

it('shows a reservation with assignee relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservation->assignee()->associate($reservationAssignee = User::factory()->create())->save();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'assignee']))
        ->assertOk()
        ->assertJsonPath('data.relationships.assignee.data.type', 'assignee')
        ->assertJsonPath('included.0.id', (string)$reservationAssignee->getKey())
        ->assertJsonPath('included.0.attributes.first_name', $reservationAssignee->first_name);
});

it('shows a reservation with assignee_group relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $reservation->assignee_group()->associate($reservationAssigneeGroup = UserGroup::factory()->create())->save();

    $this
        ->get(route('igniter.api.reservations.show', [$reservation->getKey()]).'?'.
            http_build_query(['include' => 'assignee_group']))
        ->assertOk()
        ->assertJsonPath('data.relationships.assignee_group.data.type', 'assignee_group')
        ->assertJsonPath('included.0.id', (string)$reservationAssigneeGroup->getKey())
        ->assertJsonPath('included.0.attributes.first_name', $reservation->assignee_group->first_name);
});

it('creates a reservation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);

    $this
        ->post(route('igniter.api.reservations.store'), [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test-user@domain.tld',
            'telephone' => '1234567890',
            'reserve_date' => '2022-12-31',
            'reserve_time' => '12:00',
            'guest_num' => 2,
            'status_id' => 1,
            'location_id' => 1,
            'tables' => [],
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.email', 'test-user@domain.tld');
});

it('updates a reservation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();

    $this
        ->put(route('igniter.api.reservations.update', [$reservation->getKey()]), [
            'reserve_time' => '23:00',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test-user@domain.tld',
            'telephone' => '1234567890',
            'reserve_date' => '2022-12-31',
            'guest_num' => 2,
            'status_id' => 1,
            'location_id' => 1,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.reserve_time', '23:00');
});

it('updates reservation status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $newStatus = Status::isForReservation()->first();

    $this
        ->patch(route('igniter.api.reservations.update_status', [$reservation->getKey()]), [
            'status_id' => $newStatus->getKey(),
        ])
        ->assertOk()
        ->assertJsonPath('data.id', (string)$reservation->getKey())
        ->assertJsonPath('data.attributes.status_id', $newStatus->getKey());
});

it('updates reservation status with comment and notify', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();
    $newStatus = Status::isForReservation()->first();

    $this
        ->patch(route('igniter.api.reservations.update_status', [$reservation->getKey()]), [
            'status_id' => $newStatus->getKey(),
            'comment' => 'Table confirmed',
            'notify' => true,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.status_id', $newStatus->getKey());
});

it('fails to update reservation status when status_id is missing', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();

    $this
        ->patch(route('igniter.api.reservations.update_status', [$reservation->getKey()]), [
            'comment' => 'Comment only',
        ])
        ->assertStatus(422);
});

it('can not update reservation status as customer', function(): void {
    $customer = Sanctum::actingAs(Customer::factory()->create(), ['reservations:*']);
    $customer->currentAccessToken()->shouldReceive('isForCustomer')->andReturnTrue();
    $reservation = Reservation::factory()->create();
    $newStatus = Status::isForReservation()->first();

    $this
        ->patch(route('igniter.api.reservations.update_status', [$reservation->getKey()]), [
            'status_id' => $newStatus->getKey(),
        ])
        ->assertStatus(403);
});

it('deletes a reservation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reservations:*']);
    $reservation = Reservation::factory()->create();

    $this
        ->delete(route('igniter.api.reservations.destroy', [$reservation->getKey()]))
        ->assertStatus(204);
});
