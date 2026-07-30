<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Broadcast\Classes\Manager;
use Igniter\Cart\CartCondition;
use Igniter\Cart\CartConditions\PaymentFee;
use Igniter\Cart\CartConditions\Tip;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Events\BroadcastOrderPlacedEvent;
use Igniter\Cart\Models\CartSettings;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Location as UserPosition;
use Igniter\Local\Classes\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\PayRegister\Models\Payment;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Mockery;

beforeEach(function(): void {
    $this->location = LocationModel::factory()->create();
    resolve('location')->setModel($this->location);

    $this->customer = Customer::factory()->create();
    $this->manager = new OrderManager;
});

it('sets the customer', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getKey')->andReturn(1);

    $this->manager->setCustomer($customer);

    expect($this->manager->getCustomerId())->toBe($customer->getKey());
});

it('gets customer id', function(): void {
    $this->actingAs($this->customer, 'igniter-customer');

    expect($this->manager->getCustomerId())->toBe($this->customer->id);
});

it('loads order', function(): void {
    $order = $this->manager->getOrder();

    expect($order)->toBeInstanceOf(Order::class)
        ->and($order->customer_id)->toBe($this->customer->id)
        ->and($order->location_id)->toBe($this->location->getKey());
});

it('gets order by hash', function(): void {
    $order = Order::factory()->create([
        'customer_id' => $this->customer->getKey(),
        'hash' => 'test-hash',
    ]);

    expect($this->manager->getOrderByHash($order->hash, $this->customer))->toBeInstanceOf(Order::class);
});

it('gets default payment with valid class_name', function(): void {
    expect($this->manager->getDefaultPayment())->toBeInstanceOf(Payment::class);
});

it('gets payment with valid class_name', function(): void {
    $payment = Payment::firstWhere('code', 'cod');

    expect($this->manager->getPayment($payment->code))->toBeInstanceOf(Payment::class);
});

it('has location payments', function(): void {
    $this->location->settings()->create([
        'item' => 'checkout.payments',
        'data' => ['invalid-code'],
    ]);

    expect($this->manager->getPaymentGateways()->all())->toBeEmpty();
});

it('finds delivery address', function(): void {
    $address = Address::factory()->create([
        'customer_id' => $this->customer->id,
    ]);

    expect($this->manager->findDeliveryAddress($address->getKey()))
        ->toBeInstanceOf(Address::class);
});

it('finds delivery address returns null when address is null', function(): void {
    expect($this->manager->findDeliveryAddress(null))->toBeNull();
});

it('validateCustomer throws exception when guest order is not allowed and customer is not logged in', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current->allowGuestOrder')->andReturn(false);
    $this->manager->setLocation($location);

    expect(fn() => $this->manager->validateCustomer(null))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.alert_customer_not_logged'));
});

it('validateCustomer throws exception when guest order is not allowed and customer is not activated', function(): void {
    $customer = Mockery::mock(Customer::class);
    $location = Mockery::mock(Location::class);
    $customer->shouldReceive('extendableGet')->with('is_activated')->andReturn(false);
    $location->shouldReceive('current->allowGuestOrder')->andReturn(false);
    $this->manager->setLocation($location);

    expect(fn() => $this->manager->validateCustomer($customer))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.alert_customer_not_logged'));
});

it('validateDeliveryAddress throws exception when delivery address is empty', function(): void {
    $address = [];
    Geocoder::shouldReceive('geocode')->andReturn(collect());

    expect(fn() => $this->manager->validateDeliveryAddress($address))
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_invalid_search_query'));
});

it('validateDeliveryAddress throws exception when delivery address is invalid', function(): void {
    $address = [
        'address_1' => '123 Main St',
        'city' => 'Somewhere',
        'state' => 'CA',
        'postcode' => '12345',
        'country_id' => 123,
    ];
    Geocoder::shouldReceive('geocode')->andReturn(collect());

    expect(fn() => $this->manager->validateDeliveryAddress($address))
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_invalid_search_query'));
});

it('validateDeliveryAddress throws exception when street address is missing', function(): void {
    $address = ['address_1' => '123 Main St', 'city' => 'Somewhere', 'state' => 'CA', 'postcode' => '12345'];
    $userLocation = Mockery::mock(UserPosition::class);
    $userLocation->shouldReceive('getStreetNumber')->andReturn(null);
    $userLocation->shouldReceive('getStreetName')->andReturn(null);
    Geocoder::shouldReceive('geocode')->andReturn(collect([$userLocation]));

    expect(fn() => $this->manager->validateDeliveryAddress($address))
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_missing_street_address'));
});

it('validateDeliveryAddress throws exception when delivery area is not covered', function(): void {
    $address = ['address_1' => '123 Main St', 'city' => 'Somewhere', 'state' => 'CA', 'postcode' => '12345'];
    $location = Mockery::mock(Location::class);
    $userLocation = Mockery::mock(UserPosition::class);
    $userLocation->shouldReceive('getStreetNumber')->andReturn('123');
    $userLocation->shouldReceive('getStreetName')->andReturn('Main St');
    $userLocation->shouldReceive('getCoordinates')->andReturn(new Coordinates(0, 0));
    Geocoder::shouldReceive('geocode')->andReturn(collect([$userLocation]));
    $location->shouldReceive('updateUserPosition')->once();
    $location->shouldReceive('current->searchDeliveryArea')->andReturn(null);
    $this->manager->setLocation($location);

    expect(fn() => $this->manager->validateDeliveryAddress($address))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.error_covered_area'));
});

it('validateDeliveryAddress throws exception when delivery area changes', function(): void {
    $address = ['address_1' => '123 Main St', 'city' => 'Somewhere', 'state' => 'CA', 'postcode' => '12345'];
    $location = Mockery::mock(Location::class);
    $userLocation = Mockery::mock(UserPosition::class);
    $area = Mockery::mock(LocationArea::class)->makePartial();
    $userLocation->shouldReceive('getStreetNumber')->andReturn('123');
    $userLocation->shouldReceive('getStreetName')->andReturn('Main St');
    $userLocation->shouldReceive('getCoordinates')->andReturn(new Coordinates(0, 0));
    Geocoder::shouldReceive('geocode')->andReturn(collect([$userLocation]));
    $area->shouldReceive('extendableGet')->with('area_id')->andReturn(1);
    $location->shouldReceive('updateUserPosition')->once();
    $location->shouldReceive('setCoveredArea')->once();
    $location->shouldReceive('current->searchDeliveryArea')->andReturn($area);
    $location->shouldReceive('isCurrentAreaId')->andReturn(false);
    $this->manager->setLocation($location);

    expect(fn() => $this->manager->validateDeliveryAddress($address))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.alert_delivery_area_changed'));
});

it('saves order', function(): void {
    Event::fake();

    $order = Order::factory()->create();
    $address = Address::factory()->create();
    $data = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'address_1' => '123 Main St',
        'city' => 'Somewhere',
        'state' => 'CA',
        'postcode' => '12345',
        'country_id' => 123,
    ];
    $cartCondition = Mockery::mock(CartCondition::class);
    $cartCondition->shouldReceive('withTarget')->andReturnSelf();
    $cartCondition->shouldReceive('calculate')->andReturn(10);
    $cartCondition->shouldReceive('getLabel')->andReturn('Test Condition');
    $cartCondition->shouldReceive('getValue')->andReturn(10);
    $cartCondition->shouldReceive('getPriority')->andReturn(99);
    $cartCondition->shouldReceive('__serialize')->andReturn(['name' => 'test-condition', 'value' => 10]);
    app('cart')->add(['id' => 1, 'name' => 'Menu Item', 'price' => 1, 'conditions' => [$cartCondition, $cartCondition]]);

    $manager = new OrderManager;
    $manager->setCustomer($this->customer);

    expect($manager->saveOrder($order, $data))->toBeInstanceOf(Order::class);

    Event::assertDispatched('igniter.checkout.beforeSaveOrder');
    Event::assertDispatched('igniter.checkout.afterSaveOrder');
});

it('processes payment when order total is zero or less', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
        'admin.order.paymentProcessed',
    ]);

    $order = Order::factory()->create([
        'payment' => '',
        'order_total' => 0,
    ]);

    expect($this->manager->processPayment($order, []))->toBeTrue()
        ->and($order->processed)->toBeTrue();

    Event::assertDispatched('igniter.checkout.beforePayment');
    Event::assertDispatched('admin.order.paymentProcessed');
});

it('processes payment throws exception when payment is invalid', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
    ]);

    $order = Order::factory()->create(['payment' => '']);

    expect(fn() => $this->manager->processPayment($order, []))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.error_invalid_payment'));
});

it('processes payment throws exception when payment is inactive', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
    ]);

    $payment = Payment::factory()->create(['status' => 0]);
    $order = Order::factory()->create(['payment' => $payment->code]);

    expect(fn() => $this->manager->processPayment($order, []))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.error_inactive_payment'));
});

it('processes payment throws exception when payment is not applicable', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
    ]);

    $payment = Payment::firstWhere('code', 'cod');
    $payment->order_total = 100;
    $payment->save();
    $order = Order::factory()->create(['payment' => $payment->code, 'order_total' => 50]);

    expect(fn() => $this->manager->processPayment($order, []))
        ->toThrow(ApplicationException::class, sprintf(
            lang('igniter.payregister::default.alert_min_order_total'), '£100.00', $payment->name,
        ));
});

it('processes payment throws exception when payment fee cart condition is not applied', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
    ]);
    app('cart')->loadCondition(new PaymentFee);
    $payment = Payment::firstWhere('code', 'cod');
    $payment->order_total = 100;
    $payment->order_fee = 10;
    $payment->save();
    $order = Order::factory()->create(['payment' => $payment->code, 'order_total' => 150]);

    expect(fn() => $this->manager->processPayment($order, []))
        ->toThrow(ApplicationException::class, sprintf(
            lang('igniter.payregister::default.alert_missing_applicable_fee'), $payment->name,
        ));
});

it('processes payment from saved profile', function(): void {
    $order = Mockery::mock(Order::class)->makePartial();
    $order->shouldReceive('extendableGet')->with('payment')->andReturn('test_payment');
    $order->shouldReceive('extendableGet')->with('order_total')->andReturn(100);

    $paymentMethod = Mockery::mock(Payment::class)->makePartial();
    $paymentMethod->shouldReceive('extendableGet')->with('status')->andReturn(true);
    $paymentMethod->shouldReceive('isApplicable')->with(100, $paymentMethod)->andReturn(true);
    $paymentMethod->shouldReceive('hasApplicableFee')->andReturn(false);
    $paymentMethod->shouldReceive('payFromPaymentProfile')->with($order, ['pay_from_profile' => 1])->andReturn('success');

    $orderManager = Mockery::mock(OrderManager::class)->makePartial();
    $orderManager->shouldReceive('getPayment')->with('test_payment')->andReturn($paymentMethod);

    $result = $orderManager->processPayment($order, ['pay_from_profile' => 1]);

    expect($result)->toBe('success');
});

it('processes payment', function(): void {
    Event::fake([
        'igniter.checkout.beforePayment',
    ]);
    resolve(Manager::class)->bindBroadcasts([
        'admin.order.paymentProcessed' => BroadcastOrderPlacedEvent::class,
    ]);

    $payment = Payment::firstWhere('code', 'cod');

    $order = Order::factory()->create([
        'payment' => $payment->code,
    ]);

    expect($this->manager->processPayment($order, []))->toBeNull()
        ->and($order->processed)->toBeTrue();

    Event::assertDispatched('igniter.checkout.beforePayment');
});

it('applies required attributes', function(): void {
    $order = Order::factory()->create();

    $this->manager->applyRequiredAttributes($order);

    $locationService = App::make('location');
    expect($order->customer_id)->toBe($this->manager->getCustomerId())
        ->and($order->location_id)->toBe($locationService->current()->getKey())
        ->and($order->order_type)->toBe($locationService->orderType());
});

it('applies required attributes does not apply order date time', function(): void {
    $order = Order::factory()->create([
        'order_time_is_asap' => '',
        'order_date' => '2021-12-01',
        'order_time' => '11:00',
    ]);
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current->getKey')->andReturn(1);
    $location->shouldReceive('current->listAvailablePayments')->andReturn(collect());
    $location->shouldReceive('orderDateTime')->andReturn($order->order_datetime);
    $location->shouldReceive('orderTimeIsAsap')->andReturnFalse();
    $location->shouldReceive('orderType')->andReturnNull();

    $this->manager->setLocation($location);
    $this->manager->applyRequiredAttributes($order);

    expect($order->order_time_is_asap)->toBeFalse()
        ->and($order->order_date->toDateString())->toBe('2021-12-01')
        ->and($order->order_time)->toBe('11:00');
});

it('gets cart totals', function(): void {
    CartSettings::set('enable_tipping', true);
    CartSettings::set('tip_value_type', 'F');

    $order = Order::factory()->create();
    $menu = Menu::factory()->create();

    $cartManager = resolve(CartManager::class);
    $cartManager->addCartItem($menu->getKey());

    $cartManager->getCart()->loadCondition(
        new Tip([
            'name' => 'tip',
            'label' => 'Test Tip',
            'metaData' => [
                'amount' => 10,
                'isCustom' => true,
            ],
        ]),
    );

    $totals = $this->manager->getCartTotals($order);

    expect(collect($totals)->keyBy('code')->all())
        ->toHaveKeys(['tip', 'subtotal', 'total']);
});

it('applies payment fee cart condition', function(): void {
    $menu = Menu::factory()->create();

    $cartManager = resolve(CartManager::class);
    $cartManager->addCartItem($menu->getKey());

    $condition = $this->manager->applyCurrentPaymentFee('payment-cod');

    expect($condition->getMetaData())->toBe(['code' => 'payment-cod'])
        ->and($this->manager->getSession('paymentCode'))->toBe('payment-cod');
});

it('returns default payment code when current payment code is not set', function(): void {
    $payment = Payment::firstWhere('code', 'cod');

    expect($this->manager->getCurrentPaymentCode())->toBe($payment->code);
});

it('returns null when default payment is not set', function(): void {
    $payment = Payment::firstWhere('code', 'cod');
    $payment->status = 0;
    $payment->is_default = 0;
    $payment->save();

    expect($this->manager->getCurrentPaymentCode())->toBeNull();
});

it('clears order session', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('updateScheduleTimeSlot')->with(null)->once();

    $this->manager->setLocation($location);
    $this->manager->clearOrder();
});

it('clears current order id from session', function(): void {
    expect($this->manager->clearCurrentOrderId())->toBeNull();
});

it('returns true when given order id matches current order id', function(): void {
    $this->manager->setCurrentOrderId(1);
    $result = $this->manager->isCurrentOrderId(1);

    expect($result)->toBeTrue();
});

it('returns false when given order id does not match current order id', function(): void {
    $this->manager->setCurrentOrderId(2);
    $result = $this->manager->isCurrentOrderId(1);

    expect($result)->toBeFalse();
});
