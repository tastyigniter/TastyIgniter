<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Carbon\Carbon;
use Igniter\Admin\Models\Concerns\GeneratesHash;
use Igniter\Admin\Models\Concerns\LogsStatusHistory;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Cart\Events\OrderBeforePaymentProcessedEvent;
use Igniter\Cart\Events\OrderCanceledEvent;
use Igniter\Cart\Events\OrderPaymentProcessedEvent;
use Igniter\Cart\Models\Concerns\HasInvoice;
use Igniter\Cart\Models\Concerns\ManagesOrderItems;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\OrderMenu;
use Igniter\Cart\Models\OrderMenuOptionValue;
use Igniter\Cart\Models\OrderTotal;
use Igniter\Cart\Models\Scopes\OrderScope;
use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Event;

it('returns customer addresses', function(): void {
    $customer = Customer::factory()->hasAddresses(3)->create();
    $order = Order::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);

    $result = $order->listCustomerAddresses();

    expect($result)->toBeCollection()->toHaveCount(3);
});

it('gets customer name attribute correctly', function(): void {
    $order = Order::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    expect($order->customer_name)->toBe('John Doe');
});

it('gets order type name attribute correctly', function(): void {
    $order = Order::factory()->create([
        'order_type' => Order::DELIVERY,
    ]);

    expect($order->order_type_name)->toBe(lang('igniter.local::default.text_delivery'));

    $order->location = false;

    expect($order->order_type_name)->toBe('delivery');
});

it('gets order datetime attribute correctly', function(): void {
    $order = Order::factory()->create([
        'order_date' => '2021-01-01',
        'order_time' => '12:00',
    ]);

    expect($order->order_datetime)->toBeInstanceOf(Carbon::class)
        ->and($order->order_datetime->format('Y-m-d H:i'))->toBe('2021-01-01 12:00');
});

it('gets formatted address attribute correctly', function(): void {
    $order = Order::factory()
        ->for(Address::factory()->create([
            'address_1' => '123 Main St',
            'address_2' => 'Apt. 035',
            'city' => 'City',
            'state' => 'State',
            'postcode' => '12345',
            'country_id' => Country::factory()->state(['status' => 1, 'country_name' => 'Country']),
        ]))
        ->create();

    expect($order->formatted_address)->toBe('123 Main St, Apt. 035, City 12345, State, Country');
});

it('returns correct URL with default parameters', function(): void {
    $order = Order::factory()->create();

    $result = $order->getUrl('order/view', ['foo' => 'bar']);

    expect($result)->toBe(page_url('order/view', ['id' => $order->getKey(), 'hash' => $order->hash, 'foo' => 'bar']));
});

it('returns correct URL when params is null', function(): void {
    $order = Order::factory()->create();

    $result = $order->getUrl('order/view', null);

    expect($result)->toBe(page_url('order/view', ['id' => $order->getKey(), 'hash' => $order->hash]));
});

it('checks if order is completed', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => $status->getKey(),
    ]);

    setting()->set(['completed_order_status' => $status->getKey()]);
    $order->updateOrderStatus($status->getKey());

    expect($order->isCompleted())->toBeTrue();
});

it('checks if order is not completed', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => $status->getKey(),
    ]);

    expect($order->isCompleted())->toBeFalse();
});

it('checks if order is canceled', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => $status->getKey(),
    ]);

    setting()->set(['canceled_order_status' => $status->getKey()]);
    $order->updateOrderStatus($status->getKey());

    expect($order->isCanceled())->toBeTrue();
});

it('checks if order is not canceled', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => $status->getKey(),
    ]);

    expect($order->isCanceled())->toBeFalse();
});

it('returns false when order cancellation timeout is not set', function(): void {
    $order = Order::factory()->create();
    $location = mock(Location::class)->makePartial();
    $order->location = $location;
    $location->shouldReceive('getOrderCancellationTimeout')->andReturn(null);

    expect($order->isCancelable())->toBeFalse();
});

it('returns false when order datetime is not in the future', function(): void {
    $order = Order::factory()->create([
        'order_date' => Carbon::now()->subDay()->toDateString(),
        'order_time' => Carbon::now()->subDay()->subMinutes(20)->toTimeString(),
    ]);
    $location = mock(Location::class)->makePartial();
    $order->location = $location;
    $location->shouldReceive('getOrderCancellationTimeout')->andReturn(60);

    expect($order->isCancelable())->toBeFalse();
});

it('returns true when remaining time is greater than cancellation timeout', function(): void {
    $this->travelTo(Carbon::now()->setHour(12)->setMinute(0));
    $order = Order::factory()->create([
        'order_date' => Carbon::now()->toDateString(),
        'order_time' => Carbon::now()->addMinutes(40)->toTimeString(),
    ]);
    $location = mock(Location::class)->makePartial();
    $order->location = $location;
    $location->shouldReceive('getOrderCancellationTimeout')->andReturn(30);

    expect($order->isCancelable())->toBeTrue();
});

it('checks if order is delivery type', function(): void {
    $order = Order::factory()->create([
        'order_type' => Order::DELIVERY,
    ]);

    expect($order->isDeliveryType())->toBeTrue();
});

it('checks if order is collection type', function(): void {
    $order = Order::factory()->create([
        'order_type' => Order::COLLECTION,
    ]);

    expect($order->isCollectionType())->toBeTrue();
});

it('returns an array of order dates', function(): void {
    $order = Order::factory()->create([
        'created_at' => '2023-01-01 12:00:00',
    ]);

    $result = $order->getOrderDates()->all();

    expect($result)->toBeArray()->and($result)->toContain('January 2023');
});

it('checks if order payment is processed', function(): void {
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => 1,
    ]);

    expect($order->isPaymentProcessed())->toBeTrue();
});

it('checks if order payment is not processed', function(): void {
    $order = Order::factory()->create([
        'processed' => 0,
        'status_id' => 0,
    ]);

    expect($order->isPaymentProcessed())->toBeFalse();
});

it('marks order as canceled correctly', function(): void {
    Event::fake();

    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'processed' => 1,
        'status_id' => $status->getKey(),
    ]);

    setting()->set(['canceled_order_status' => $status->getKey()]);
    $order->updateOrderStatus($status->getKey());

    expect($order->markAsCanceled())->toBeTrue();
    Event::assertDispatched(OrderCanceledEvent::class);
});

it('marks order payment as processed correctly', function(): void {
    Event::fake();

    $order = Order::factory()->create();

    expect($order->markAsPaymentProcessed())->toBeTrue();
    Event::assertDispatched(OrderBeforePaymentProcessedEvent::class);
    Event::assertDispatched(OrderPaymentProcessedEvent::class);
});

it('logs payment attempt correctly', function(): void {
    $order = Order::factory()
        ->for(Payment::factory()->create(), 'payment_method')
        ->create();

    $order->logPaymentAttempt('Payment processed', true);

    expect($order->payment_logs()->count())->toBe(1);
});

it('updates order status correctly', function(): void {
    $order = Order::factory()->create();

    $status = Status::factory()->create();
    expect($order->updateOrderStatus($status->getKey()))->toBeInstanceOf(StatusHistory::class);
});

it('gets mail recipients correctly for customer type', function(): void {
    $order = Order::factory()->create([
        'email' => 'customer@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    setting()->set(['order_email' => ['customer']]);

    $recipients = $order->mailGetRecipients('customer');

    expect($recipients)->toBe([[$order->email, $order->customer_name]]);
});

it('gets mail recipients correctly for location type', function(): void {
    $location = Location::factory()->create();
    $order = Order::factory()->for($location)->create();

    setting()->set(['order_email' => ['location']]);

    $recipients = $order->mailGetRecipients('location');

    expect($recipients)->toBe([[$location->location_email, $location->location_name]]);
});

it('gets mail recipients correctly for admin type', function(): void {
    $order = Order::factory()->create();

    setting()->set(['order_email' => ['admin']]);

    $recipients = $order->mailGetRecipients('admin');

    expect($recipients)->toBe([[setting('site_email'), setting('site_name')]]);
});

it('returns empty array when type is not in order email settings', function(): void {
    $order = Order::factory()->create([
        'email' => 'customer@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    setting()->set('order_email', ['admin']);

    $result = $order->mailGetReplyTo('admin');

    expect($result)->toBeArray()
        ->and($result)->toContain('customer@example.com')
        ->and($result)->toContain('John Doe');
});

it('returns order data with all fields populated', function(): void {
    $order = Order::factory()->create([
        'address_id' => Address::factory(),
    ]);
    $menuItemOption = MenuItemOption::factory()->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()->create();
    $orderMenu = $order->menus()->create([
        'menu_id' => Menu::factory()->create()->getKey(),
        'name' => 'Menu Name',
        'quantity' => 5,
        'price' => 20,
        'subtotal' => 100,
    ]);
    $orderMenu->menu_options()->create([
        'order_id' => $order->getKey(),
        'order_menu_id' => $orderMenu->getKey(),
        'order_option_name' => 'Option Name',
        'order_option_price' => 10,
        'menu_option_value_id' => $menuItemOptionValue->getKey(),
        'menu_option_id' => $menuItemOption->getKey(),
        'quantity' => 5,
    ]);
    $order->totals()->create([
        'code' => 'subtotal',
        'title' => 'Subtotal',
        'value' => 100,
    ]);

    $result = $order->mailGetData();

    expect($result['order_menus'])->not->toBeEmpty()
        ->and($result['order_menus'][0]['menu_options'])->toContain('Option Name')
        ->and($result['order_totals'])->not->toBeEmpty()
        ->and($result['order_address'])->not->toBeEmpty()
        ->and($result['location_name'])->not->toBeEmpty();
});

it('applies filters on the query builder', function(): void {
    $query = Order::query()->applyFilters([
        'customer' => 1,
        'dateTimeFilter' => 1,
        'location' => 1,
        'status' => 1,
        'sort' => 'order_date desc',
        'search' => 'John Doe',
    ]);

    expect($query->toSql())
        ->toContain('and `status_id` in (?)')
        ->toContain('and `location_id` in (?)')
        ->toContain('and `orders`.`customer_id` = ?')
        ->toContain('ADDTIME(order_date, order_time) between ? and ?')
        ->toContain('lower(first_name)', 'lower(last_name)', 'lower(email)')
        ->toContain('order by `order_date` desc');
});

it('generates order hash on create correctly', function(): void {
    $order = Order::factory()->create();

    expect($order->hash)->not->toBeEmpty();
});

it('configures order model correctly', function(): void {
    $order = new Order;

    expect(class_uses($order))
        ->toHaveKey(Assignable::class)
        ->toHaveKey(GeneratesHash::class)
        ->toHaveKey(HasCustomer::class)
        ->toHaveKey(HasInvoice::class)
        ->toHaveKey(Locationable::class)
        ->toHaveKey(LogsStatusHistory::class)
        ->toHaveKey(ManagesOrderItems::class)
        ->toHaveKey(SendsMailTemplate::class)
        ->and($order->getTable())->toBe('orders')
        ->and($order->getKeyName())->toBe('order_id')
        ->and($order->getGuarded())->toEqual([
            'ip_address', 'user_agent', 'hash', 'total_items', 'order_total',
        ])
        ->and($order->getAppends())->toEqual([
            'customer_name', 'order_type_name', 'order_date_time', 'formatted_address', 'status_name',
        ])
        ->and($order->getHidden())->toEqual(['cart'])
        ->and($order->timestamps)->toBeTrue()
        ->and($order->getMorphClass())->toBe('orders')
        ->and($order->getCasts())->toBe([
            'order_id' => 'int',
            'customer_id' => 'integer',
            'location_id' => 'integer',
            'address_id' => 'integer',
            'total_items' => 'integer',
            'cart' => Serialize::class,
            'order_date' => 'date',
            'order_time' => 'time',
            'order_total' => 'float',
            'notify' => 'boolean',
            'processed' => 'boolean',
            'order_time_is_asap' => 'boolean',
            'assignee_id' => 'integer',
            'assignee_group_id' => 'integer',
            'assignee_updated_at' => 'datetime',
            'invoice_date' => 'datetime',
            'status_id' => 'integer',
            'status_updated_at' => 'datetime',
        ])
        ->and($order->relation['belongsTo']['customer'])->toEqual(Customer::class)
        ->and($order->relation['belongsTo']['location'])->toEqual(Location::class)
        ->and($order->relation['belongsTo']['address'])->toEqual(Address::class)
        ->and($order->relation['belongsTo']['payment_method'])->toEqual([Payment::class, 'foreignKey' => 'payment', 'otherKey' => 'code'])
        ->and($order->relation['hasMany']['payment_logs'])->toEqual(PaymentLog::class)
        ->and($order->relation['hasMany']['menus'])->toEqual(OrderMenu::class)
        ->and($order->relation['hasMany']['menu_options'])->toEqual(OrderMenuOptionValue::class)
        ->and($order->relation['hasMany']['totals'])->toEqual(OrderTotal::class)
        ->and($order->getGlobalScopes())->toHaveKey(OrderScope::class);
});
