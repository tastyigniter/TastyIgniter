<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\System\Models\Concerns\Defaultable;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Mockery;

it('returns dropdown options for customer groups', function(): void {
    $group1 = CustomerGroup::factory()->create(['group_name' => 'VIP']);
    $group2 = CustomerGroup::factory()->create(['group_name' => 'Regular']);

    $result = CustomerGroup::getDropdownOptions();

    expect($result[$group1->getKey()])->toBe('VIP')
        ->and($result[$group2->getKey()])->toBe('Regular');
});

it('returns true when group requires approval', function(): void {
    $customerGroup = Mockery::mock(CustomerGroup::class)->makePartial();
    $customerGroup->approval = true;

    $result = $customerGroup->requiresApproval();

    expect($result)->toBeTrue();
});

it('returns false when group does not require approval', function(): void {
    $customerGroup = Mockery::mock(CustomerGroup::class)->makePartial();
    $customerGroup->approval = false;

    $result = $customerGroup->requiresApproval();

    expect($result)->toBeFalse();
});

it('returns correct customer count', function(): void {
    $customerGroup = Mockery::mock(CustomerGroup::class)->makePartial();
    $customerGroup->customers_count = 5;

    $result = $customerGroup->getCustomerCountAttribute(null);

    expect($result)->toBe(5);
});

it('returns the correct defaultable name', function(): void {
    $customerGroup = Mockery::mock(CustomerGroup::class)->makePartial();
    $customerGroup->group_name = 'VIP';

    $result = $customerGroup->defaultableName();

    expect($result)->toBe('VIP');
});

it('configures customer group model correctly', function(): void {
    $customerGroup = new CustomerGroup;

    expect(class_uses_recursive($customerGroup))
        ->toContain(Defaultable::class)
        ->and($customerGroup->getTable())->toBe('customer_groups')
        ->and($customerGroup->getKeyName())->toBe('customer_group_id')
        ->and($customerGroup->timestamps)->toBeTrue()
        ->and($customerGroup->getCasts()['approval'])->toBe('boolean')
        ->and($customerGroup->relation['hasMany']['customers'])->toBe(Customer::class);
});
