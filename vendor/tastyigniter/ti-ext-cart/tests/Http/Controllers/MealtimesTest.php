<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Controllers;

use Igniter\Cart\Models\Mealtime;

it('loads mealtimes page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.mealtimes'))
        ->assertOk();
});

it('loads create mealtime page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.mealtimes', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit mealtime page', function(): void {
    $mealtime = Mealtime::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.mealtimes', ['slug' => 'edit/'.$mealtime->getKey()]))
        ->assertOk();
});

it('loads mealtime preview page', function(): void {
    $mealtime = Mealtime::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.mealtimes', ['slug' => 'preview/'.$mealtime->getKey()]))
        ->assertOk();
});

it('creates mealtime', function(): void {
    $url = route('igniter.cart.mealtimes', ['slug' => 'create']);
    actingAsSuperUser()
        ->post($url, [
            'Mealtime' => [
                'mealtime_name' => 'Test Mealtime',
                'validity' => 'daily',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'mealtime_status' => '1',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Mealtime::where('mealtime_name', 'Test Mealtime')->first())->not->toBeNull();
});

it('updates mealtime', function(): void {
    $mealtime = Mealtime::factory()->create();

    $url = route('igniter.cart.mealtimes', ['slug' => 'edit/'.$mealtime->getKey()]);
    actingAsSuperUser()
        ->post($url, [
            'Mealtime' => [
                'mealtime_name' => 'Updated Mealtime',
                'validity' => 'daily',
                'start_time' => '12:00',
                'end_time' => '14:00',
                'mealtime_status' => '1',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Mealtime::find($mealtime->getKey()))->mealtime_name->toBe('Updated Mealtime');
});

it('deletes mealtime', function(): void {
    $mealtime = Mealtime::factory()->create();

    $url = route('igniter.cart.mealtimes', ['slug' => 'edit/'.$mealtime->getKey()]);
    actingAsSuperUser()
        ->post($url, [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Mealtime::find($mealtime->getKey()))->toBeNull();
});
