<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models\Observers;

use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Igniter\User\Models\Observers\CustomerObserver;
use Mockery;

it('saves customer guest order on created', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('saveCustomerGuestOrder')->once();

    $observer = new CustomerObserver;
    $observer->created($customer);
});

it('completes activation if group does not require approval and status is true', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $group = Mockery::mock(CustomerGroup::class);
    $group->shouldReceive('requiresApproval')->andReturn(false);
    $customer->status = true;
    $customer->is_activated = null;
    $customer->shouldReceive('extendableGet')->with('group')->andReturn($group);
    $customer->shouldReceive('restorePurgedValues')->once();
    $customer->shouldReceive('completeActivation')->with(Mockery::type('string'))->once();
    $customer->exists = true;

    $observer = new CustomerObserver;
    $observer->saved($customer);
});

it('saves addresses if addresses attribute exists', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getAttributes')->andReturn(['addresses' => ['address1', 'address2']]);
    $customer->shouldReceive('saveAddresses')->with(['address1', 'address2'])->once();
    $customer->exists = true;

    $observer = new CustomerObserver;
    $observer->saved($customer);
});

it('deletes addresses on deleting', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $addresses = Mockery::mock();
    $addresses->shouldReceive('delete')->once();
    $customer->shouldReceive('addresses')->andReturn($addresses);

    $observer = new CustomerObserver;
    $observer->deleting($customer);
});
