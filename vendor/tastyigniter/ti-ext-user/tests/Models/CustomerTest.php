<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Address;
use Igniter\User\Models\Concerns\SendsInvite;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Illuminate\Support\Carbon;
use Mockery;

it('returns dropdown options for enabled customers', function(): void {
    $customer = Customer::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);

    $result = Customer::getDropdownOptions();

    expect($result[$customer->getKey()])->toBe('John Doe');
});

it('returns empty array when no enabled customers are present', function(): void {
    $result = Customer::getDropdownOptions();

    expect($result)->toBeEmpty();
});

it('returns full name as concatenation of first and last name', function(): void {
    $customer = new Customer;
    $customer->first_name = 'John';
    $customer->last_name = 'Doe';

    expect($customer->full_name)->toBe('John Doe');
});

it('returns email in lowercase', function(): void {
    $customer = new Customer;
    $customer->email = 'John.Doe@Example.com';

    expect($customer->email)->toBe('john.doe@example.com');
});

it('returns when group does not require approval', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $group = Mockery::mock(CustomerGroup::class)->makePartial();
    $group->shouldReceive('requiresApproval')->andReturnFalse();
    $customer->group = $group;

    $result = $customer->beforeLogin();

    expect($result)->toBeNull();
});

it('returns when customer is activated and enabled', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $group = Mockery::mock(CustomerGroup::class)->makePartial();
    $group->shouldReceive('requiresApproval')->andReturnTrue();
    $customer->is_activated = true;
    $customer->group = $group;
    $customer->shouldReceive('isEnabled')->andReturnTrue();

    $result = $customer->beforeLogin();

    expect($result)->toBeNull();
});

it('throws exception if customer group requires approval and customer is not activated', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $group = Mockery::mock(CustomerGroup::class)->makePartial();
    $group->shouldReceive('requiresApproval')->andReturnTrue();
    $customer->group = $group;
    $customer->is_activated = false;
    $customer->shouldReceive('isEnabled')->andReturnTrue();

    expect(fn() => $customer->beforeLogin())->toThrow(SystemException::class);
});

it('updates last login timestamp after login', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('saveQuietly')->once();

    $customer->afterLogin();

    expect($customer->last_login)->toBeInstanceOf(Carbon::class);
});

it('extends user query to include only enabled users', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('isEnabled')->once();

    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->extendUserQuery($query);
});

it('returns true when customer is enabled', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('isEnabled')->andReturnTrue();

    $result = $customer->enabled();

    expect($result)->toBeTrue();
});

it('returns addresses grouped by their keys', function(): void {
    $address1 = Mockery::mock(Address::class)->makePartial();
    $address1->shouldReceive('getKey')->andReturn(1);
    $address2 = Mockery::mock(Address::class)->makePartial();
    $address2->shouldReceive('getKey')->andReturn(2);

    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('addresses->get')->andReturn(collect([$address1, $address2]));

    $result = $customer->listAddresses();

    expect($result->keys()->all())->toBe([1, 2]);
});

it('returns empty collection when no addresses are present', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('addresses->get')->andReturn(collect());

    $result = $customer->listAddresses();

    expect($result->isEmpty())->toBeTrue();
});

it('returns all customer registration dates', function(): void {
    $dates = ['2023-01-01', '2023-02-01'];
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('pluckDates')->with('created_at')->andReturn($dates);

    $result = $customer->getCustomerDates();

    expect($result)->toBe($dates);
});

it('returns empty array when no registration dates are present', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('pluckDates')->with('created_at')->andReturn([]);

    $result = $customer->getCustomerDates();

    expect($result)->toBe([]);
});

it('saves addresses and deletes old addresses not in the list', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getKey')->andReturn(1);
    $customer->shouldReceive('addresses->updateOrCreate')->andReturnUsing(function($attributes, $values) {
        $address = Mockery::mock(Address::class);
        $address->shouldReceive('getKey')->andReturn(1);

        return $address;
    });
    $customer->shouldReceive('addresses->whereNotIn->delete')->once();

    $addresses = [
        ['address_id' => 1, 'country_id' => 1, 'address' => '123 Street'],
        ['address_id' => 2, 'address' => '456 Avenue'],
    ];

    $customer->saveAddresses($addresses);
});

it('returns false when saving addresses if customer key is not numeric', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getKey')->andReturn(null);

    $result = $customer->saveAddresses([]);

    expect($result)->toBeFalse();
});

it('throws exception when saving default address if address does not belong to customer', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('addresses->find')->andReturn(null);

    expect(fn() => $customer->saveDefaultAddress(1))->toThrow(ApplicationException::class);
});

it('sets default address for customer', function(): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->shouldReceive('getKey')->andReturn(1);

    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('addresses->find')->andReturn($address);
    $customer->shouldReceive('save')->once();

    $result = $customer->saveDefaultAddress(1);

    expect($result->address_id)->toBe(1);
});

it('deletes customer address if it belongs to the customer', function(): void {
    $address = Mockery::mock(Address::class);
    $address->shouldReceive('delete')->once();

    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('addresses->find')->andReturn($address);

    $result = $customer->deleteCustomerAddress(1);

    expect($result)->toBe($address);
});

it('updates guest orders, address and reservations matching customer email', function(): void {
    $customer = Customer::factory()->create();
    $customer->email = 'john.doe@example.com';
    $address = Address::factory()->create();
    $reservation = Reservation::factory()->create(['email' => $customer->email]);
    $order = Order::factory()->create([
        'customer_id' => null,
        'email' => $customer->email,
        'address_id' => $address->getKey(),
    ]);

    $customerId = $customer->getKey();
    $result = $customer->saveCustomerGuestOrder();

    expect($result)->toBeTrue()
        ->and($reservation->fresh()->customer_id)->toBe($customerId)
        ->and($order->fresh()->customer_id)->toBe($customerId)
        ->and($address->fresh()->customer_id)->toBe($customerId);
});

it('sends invite email to customer', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.invite_customer', 'customer', [])->once();

    $customer->mailSendInvite();
});

it('sends reset password request email with default links', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.password_reset_request', 'customer', [
        'reset_link' => null,
        'account_login_link' => null,
    ])->once();

    $customer->mailSendResetPasswordRequest();
});

it('sends reset password email with default login link', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.password_reset', 'customer', [
        'account_login_link' => null,
    ])->once();

    $customer->mailSendResetPassword();
});

it('sends registration email to customer and admin if settings allow', function(): void {
    $vars = [
        'account_login_link' => null,
    ];
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.registration', 'customer', $vars)->once();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.registration_alert', 'admin', $vars)->once();
    $customer->shouldReceive('fresh')->andReturnSelf();

    setting()->set(['registration_email' => ['customer', 'admin']]);

    $customer->mailSendRegistration();
});

it('does not send registration email when disabled', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldNotReceive('mailSend');

    setting()->set(['registration_email' => '']);

    $customer->mailSendRegistration();
});

it('sends email verification email to customer', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('fresh')->andReturnSelf();
    $customer->shouldReceive('mailSend')->with('igniter.user::mail.activation', 'customer', [
        'account_activation_link' => null,
    ])->once();

    $customer->mailSendEmailVerification(['account_activation_link' => null]);
});

it('returns correct recipients for customer type', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->email = 'john.doe@example.com';
    $customer->first_name = 'John';
    $customer->last_name = 'Doe';

    $result = $customer->mailGetRecipients('customer');

    expect($result)->toBe([['john.doe@example.com', 'John Doe']]);
});

it('returns correct recipients for admin type', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();

    setting()->set(['site_email' => 'admin@example.com', 'site_name' => 'Admin']);

    $result = $customer->mailGetRecipients('admin');

    expect($result)->toBe([['admin@example.com', 'Admin']]);
});

it('returns empty array for unknown recipient type', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();

    $result = $customer->mailGetRecipients('unknown');

    expect($result)->toBe([]);
});

it('returns correct mail data', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('fresh')->andReturnSelf();
    $customer->email = 'john.doe@example.com';
    $customer->first_name = 'John';
    $customer->last_name = 'Doe';

    $result = $customer->mailGetData();

    expect($result['email'])->toBe('john.doe@example.com')
        ->and($result['full_name'])->toBe('John Doe')
        ->and($result['customer'])->toBe($customer);
});

it('registers a new customer and activates if specified', function(): void {
    $attributes = ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com'];

    $result = (new Customer)->register($attributes, true);

    expect($result->first_name)->toBe('John')
        ->and($result->last_name)->toBe('Doe')
        ->and($result->email)->toBe('john.doe@example.com')
        ->and($result->password)->toBeNull();
});

it('returns correct broadcast notification channel', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getKey')->andReturn(1);

    $result = $customer->receivesBroadcastNotificationsOn();

    expect($result)->toBe('main.users.1');
});

it('configures customer model correctly', function(): void {
    $customer = new Customer;

    expect(class_uses_recursive($customer))
        ->toContain(Purgeable::class)
        ->toContain(SendsInvite::class)
        ->toContain(SendsMailTemplate::class)
        ->toContain(Switchable::class)
        ->and($customer->getTable())->toBe('customers')
        ->and($customer->getKeyName())->toBe('customer_id')
        ->and($customer->getGuarded())->toBe(['reset_code', 'activation_code', 'remember_token'])
        ->and($customer->getHidden())->toBe(['password', 'remember_token'])
        ->and($customer->getAppends())->toBe(['full_name'])
        ->and($customer->getCasts()['customer_id'])->toBe('integer')
        ->and($customer->getCasts()['password'])->toBe('hashed')
        ->and($customer->getCasts()['address_id'])->toBe('integer')
        ->and($customer->getCasts()['customer_group_id'])->toBe('integer')
        ->and($customer->getCasts()['newsletter'])->toBe('boolean')
        ->and($customer->getCasts()['is_activated'])->toBe('boolean')
        ->and($customer->getCasts()['last_login'])->toBe('datetime')
        ->and($customer->getCasts()['invited_at'])->toBe('datetime')
        ->and($customer->getCasts()['activated_at'])->toBe('datetime')
        ->and($customer->getCasts()['reset_time'])->toBe('datetime')
        ->and($customer->relation['hasMany']['addresses'])->toBe([Address::class, 'delete' => true])
        ->and($customer->relation['hasMany']['orders'])->toBe([Order::class])
        ->and($customer->relation['hasMany']['reservations'])->toBe([Reservation::class])
        ->and($customer->relation['belongsTo']['group'])->toBe([CustomerGroup::class, 'foreignKey' => 'customer_group_id'])
        ->and($customer->relation['belongsTo']['address'])->toBe(Address::class)
        ->and($customer->getPurgeableAttributes())->toBe(['addresses', 'send_invite']);
});
