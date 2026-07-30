<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\User\Models\CustomerGroup;

it('loads customer groups page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.customer_groups'))
        ->assertOk();
});

it('loads create customer group page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.customer_groups', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit customer group page', function(): void {
    $customerGroup = CustomerGroup::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.customer_groups', ['slug' => 'edit/'.$customerGroup->getKey()]))
        ->assertOk();
});

it('loads customer group preview page', function(): void {
    $customerGroup = CustomerGroup::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.customer_groups', ['slug' => 'preview/'.$customerGroup->getKey()]))
        ->assertOk();
});

it('sets a default customer group', function(): void {
    CustomerGroup::clearDefaultModel();
    $customerGroup = CustomerGroup::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.customer_groups'), [
            'default' => $customerGroup->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSetDefault',
        ]);

    expect(CustomerGroup::getDefaultKey())->toBe($customerGroup->getKey());
});

it('creates customer group', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.customer_groups', ['slug' => 'create']), [
            'CustomerGroup' => [
                'group_name' => 'Created Customer Group',
                'approval' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(CustomerGroup::where('group_name', 'Created Customer Group')->exists())->toBeTrue();
});

it('updates customer group', function(): void {
    $customerGroup = CustomerGroup::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.customer_groups', ['slug' => 'edit/'.$customerGroup->getKey()]), [
            'CustomerGroup' => [
                'group_name' => 'Updated Customer Group',
                'approval' => 0,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(CustomerGroup::where('group_name', 'Updated Customer Group')->exists())->toBeTrue();
});

it('deletes customer group', function(): void {
    $customerGroup = CustomerGroup::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.customer_groups', ['slug' => 'edit/'.$customerGroup->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(CustomerGroup::find($customerGroup->getKey()))->toBeNull();
});

it('bulk deletes customer groups', function(): void {
    $customerGroup = CustomerGroup::factory()->count(5)->create();
    $customerGroupIds = $customerGroup->pluck('customer_group_id')->all();

    actingAsSuperUser()
        ->post(route('igniter.user.customer_groups'), [
            'checked' => $customerGroupIds,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(CustomerGroup::whereIn('customer_group_id',
        $customerGroupIds,
    )->exists())->toBeFalse();
});
