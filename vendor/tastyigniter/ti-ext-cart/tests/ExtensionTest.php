<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\Http\Controllers\Dashboard;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\AutomationRules\Conditions\OrderAttribute;
use Igniter\Cart\AutomationRules\Conditions\OrderStatusAttribute;
use Igniter\Cart\AutomationRules\Events\NewOrderStatus;
use Igniter\Cart\AutomationRules\Events\OrderAssigned;
use Igniter\Cart\AutomationRules\Events\OrderPlaced;
use Igniter\Cart\CartConditions\PaymentFee;
use Igniter\Cart\CartConditions\Tax;
use Igniter\Cart\CartConditions\Tip;
use Igniter\Cart\Events\BroadcastOrderPlacedEvent;
use Igniter\Cart\Extension;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\FormWidgets\StockEditor;
use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Cart\Http\Middleware\InjectStatusWorkflow;
use Igniter\Cart\Http\Requests\CheckoutSettingsRequest;
use Igniter\Cart\Http\Requests\CollectionSettingsRequest;
use Igniter\Cart\Http\Requests\DeliverySettingsRequest;
use Igniter\Cart\Models\CartSettings;
use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\Stock;
use Igniter\Cart\Notifications\OrderCreatedNotification;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\PayRegister\Models\Payment;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\System\Models\Settings;
use Igniter\User\Facades\Auth;
use Igniter\User\Http\Controllers\Customers;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\Customer;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Mockery;

it('registers cart conditions correctly', function(): void {
    $extension = new Extension(app());

    $conditions = $extension->registerCartConditions();

    expect($conditions)->toBeArray()
        ->and($conditions)->toHaveKey(PaymentFee::class)
        ->and($conditions)->toHaveKey(Tax::class)
        ->and($conditions)->toHaveKey(Tip::class);
});

it('registers automation rules correctly', function(): void {
    $extension = new Extension(app());

    $rules = $extension->registerAutomationRules();

    expect($rules)->toBeArray()
        ->toHaveKeys(['events', 'conditions', 'actions'])
        ->and(OrderPlaced::class)->toBe($rules['events']['admin.order.paymentProcessed'])
        ->and(NewOrderStatus::class)->toBe($rules['events']['igniter.cart.orderStatusAdded'])
        ->and(OrderAssigned::class)->toBe($rules['events']['igniter.cart.orderAssigned'])
        ->and($rules['conditions'])->toContain(OrderAttribute::class, OrderStatusAttribute::class);
});

it('registers permissions correctly', function(): void {
    $extension = new Extension(app());

    $permissions = $extension->registerPermissions();

    expect($permissions)->toBeArray()
        ->and($permissions)->toHaveKey('Admin.Allergens')
        ->and($permissions)->toHaveKey('Admin.Categories')
        ->and($permissions)->toHaveKey('Admin.Menus')
        ->and($permissions)->toHaveKey('Admin.Mealtimes')
        ->and($permissions)->toHaveKey('Admin.Orders')
        ->and($permissions)->toHaveKey('Admin.DeleteOrders')
        ->and($permissions)->toHaveKey('Admin.AssignOrders')
        ->and($permissions)->toHaveKey('Module.CartModule');
});

it('registers settings correctly', function(): void {
    $extension = new Extension(app());

    $settings = $extension->registerSettings();

    expect($settings)->toBeArray()
        ->and($settings)->toHaveKey('settings')
        ->and($settings['settings']['model'])->toBe(CartSettings::class)
        ->and($settings['settings']['permissions'])->toBe(['Module.CartModule']);
});

it('registers mail templates correctly', function(): void {
    $extension = new Extension(app());

    $templates = $extension->registerMailTemplates();

    expect($templates)->toBeArray()
        ->and($templates)->toHaveKey('igniter.cart::mail.order')
        ->and($templates)->toHaveKey('igniter.cart::mail.order_alert')
        ->and($templates)->toHaveKey('igniter.cart::mail.order_update')
        ->and($templates)->toHaveKey('igniter.cart::mail.low_stock_alert');
});

it('registers navigation correctly', function(): void {
    $extension = new Extension(app());

    $navigation = $extension->registerNavigation();

    expect($navigation)->toBeArray()
        ->and($navigation)->toHaveKey('restaurant')
        ->and($navigation)->toHaveKey('orders')
        ->and($navigation['restaurant']['child'])->toHaveKey('menus')
        ->and($navigation['restaurant']['child'])->toHaveKey('mealtimes');
});

it('registers form widgets correctly', function(): void {
    $extension = new Extension(app());

    $widgets = $extension->registerFormWidgets();

    expect($widgets)->toBeArray()
        ->and($widgets)->toHaveKey(StockEditor::class);
});

it('registers location settings correctly', function(): void {
    $extension = new Extension(app());

    $result = $extension->registerLocationSettings();

    expect($result)->toEqual([
        'checkout' => [
            'label' => 'igniter.cart::default.settings.text_tab_checkout',
            'description' => 'igniter.cart::default.settings.text_tab_desc_checkout',
            'icon' => 'fa fa-sliders',
            'priority' => 0,
            'form' => 'igniter.cart::/models/checkoutsettings',
            'request' => CheckoutSettingsRequest::class,
        ],
        'delivery' => [
            'label' => 'igniter.cart::default.settings.text_tab_delivery',
            'description' => 'igniter.cart::default.settings.text_tab_desc_delivery',
            'icon' => 'fa fa-sliders',
            'priority' => 0,
            'form' => 'igniter.cart::/models/deliverysettings',
            'request' => DeliverySettingsRequest::class,
        ],
        'collection' => [
            'label' => 'igniter.cart::default.settings.text_tab_collection',
            'description' => 'igniter.cart::default.settings.text_tab_desc_collection',
            'icon' => 'fa fa-sliders',
            'priority' => 0,
            'form' => 'igniter.cart::/models/collectionsettings',
            'request' => CollectionSettingsRequest::class,
        ],
    ]);
});

it('registers event broadcasts correctly', function(): void {
    $extension = new Extension(app());

    $broadcasts = $extension->registerEventBroadcasts();

    expect($broadcasts)->toBeArray()
        ->and($broadcasts)->toHaveKey('admin.order.paymentProcessed', BroadcastOrderPlacedEvent::class);
});

it('registers schedule that clears expired stock overrides', function(): void {
    $expired = Stock::factory()->outOfStockUntil(now()->subHour())->create();

    $schedule = new Schedule;
    (new Extension(app()))->registerSchedule($schedule);

    $event = collect($schedule->events())->first(fn($e): bool => $e instanceof CallbackEvent);
    expect($event)->not->toBeNull();

    $event->run(app());

    $expired->refresh();
    expect($expired->out_of_stock_type)->toBeNull()
        ->and($expired->out_of_stock_until)->toBeNull();
});

it('returns registered core settings', function(): void {
    $items = (new Settings)->listSettingItems();

    expect(collect($items['core'])->firstWhere('code', 'order'))->not->toBeNull();
});

it('registers onboarding steps', function(): void {
    $extension = new Extension(app());
    $steps = $extension->registerOnboardingSteps();

    expect($steps)->toHaveKey('igniter.cart::menus')
        ->and($steps['igniter.cart::menus']['label'])->toBe('igniter.cart::default.dashboard.text_onboarding_menus');
});

it('restores cart session on login correctly', function(): void {
    CartSettings::set('abandoned_cart', 1);
    $customer = Customer::factory()->create();

    Cart::shouldReceive('content->isEmpty')->andReturnTrue();
    Cart::shouldReceive('restore')->with($customer->getKey())->once();

    Auth::shouldReceive('getId')->andReturn($customer->getKey());

    event('igniter.user.login', [$customer]);
});

it('destroys cart session on logout correctly', function(): void {
    CartSettings::set('destroy_on_logout', 1);
    $customer = Customer::factory()->create();

    Cart::shouldReceive('destroy')->once();

    event('igniter.user.logout', [$customer]);
});

it('adds tax info to paypalexpress request parameters', function(): void {
    $fields = [];
    $data = [];
    $payment = Payment::firstWhere('code', 'paypalexpress');
    $order = Order::factory()->create();
    $order->totals()->create([
        'code' => 'tax',
        'title' => 'Tax',
        'value' => 10,
    ]);

    array_set($fields, 'purchase_units.0.amount.currency_code', 'GBP');

    event('payregister.paypalexpress.extendFields', [$payment, &$fields, $order, $data]);

    expect(array_get($fields, 'purchase_units.0.amount.breakdown.tax_total.value'))->toBe('10.00')
        ->and(array_get($fields, 'purchase_units.0.amount.breakdown.tax_total.currency_code'))->toBe('GBP');
});

it('subtracts stocks before payment is processed', function(): void {
    $orderMock = Mockery::mock(Order::class);
    $orderMock->shouldReceive('subtractStock')->once();

    event('admin.order.beforePaymentProcessed', [$orderMock]);
});

it('sends order confirmation after payment is processed', function(): void {
    $orderMock = Mockery::mock(Order::class)->makePartial();
    $notificationMock = Mockery::mock(OrderCreatedNotification::class);
    $notificationMock->shouldReceive('subject')->with($orderMock)->andReturnSelf();
    $notificationMock->shouldReceive('broadcast')->andReturnSelf();
    app()->instance(OrderCreatedNotification::class, $notificationMock);
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $orderMock->shouldReceive('mailGetData')->andReturn([]);
    $orderMock->shouldReceive('mailSend')->with('igniter.cart::mail.order', 'customer')->once();
    $orderMock->shouldReceive('mailSend')->with('igniter.cart::mail.order_alert', 'location')->once();
    $orderMock->shouldReceive('mailSend')->with('igniter.cart::mail.order_alert', 'admin')->once();
    $orderMock->shouldReceive('redeemCoupon')->once();

    event('admin.order.paymentProcessed', [$orderMock]);
    event('admin.assignable.assigned', [$orderMock, $assignableLog]);
});

it('sends order update after status is updated', function(): void {
    Mail::fake();
    $order = Order::factory()->create();
    $statusHistory = StatusHistory::factory()->create([
        'object_id' => $order->order_id,
        'object_type' => 'orders',
        'notify' => true,
    ]);

    event('igniter.cart.orderStatusAdded', [$order, $statusHistory]);

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mail): bool => $mail->getTemplateCode() === 'igniter.cart::mail.order_update');
});

it('adds cart middleware to frontend routes', function(): void {
    $middlewareGroups = Route::getMiddlewareGroups();
    expect($middlewareGroups)->toHaveKey('igniter')
        ->and($middlewareGroups['igniter'])->toContain(CartMiddleware::class);
});

it('adds inject status workflow middleware to admin routes', function(): void {
    Igniter::shouldReceive('runningInAdmin')->andReturnTrue();
    $extension = new Extension(app());
    $extension->boot();

    $middlewareGroups = Route::getMiddlewareGroups();
    expect($middlewareGroups)->toHaveKey('igniter')
        ->and($middlewareGroups['igniter'])->toContain(InjectStatusWorkflow::class);
});

it('returns registered dashboard charts', function(): void {
    $charts = new class(resolve(Dashboard::class)) extends Charts
    {
        public function testDatasets()
        {
            return $this->listSets();
        }
    };
    $datasets = $charts->testDatasets();

    expect($datasets['reports']['sets']['orders']['model'])->toBe(Order::class);
});

it('returns registered dashboard statistic widgets', function(): void {
    $statistics = new class(resolve(Dashboard::class)) extends Statistics
    {
        public function testCards(): array
        {
            return $this->listCards();
        }
    };
    $cards = $statistics->testCards();

    expect(array_keys($cards))->toContain(
        'sale',
        'lost_sale',
        'cash_payment',
        'order',
        'delivery_order',
        'collection_order',
        'completed_order',
    );
});

it('does not add orders tab to customer edit form when model is invalid', function(): void {
    $model = mock(Model::class)->makePartial();
    $form = new Form(resolve(Customers::class), ['model' => $model, 'context' => 'edit']);
    $form->bindToController();

    $fields = $form->getFields();

    expect($fields)->not->toHaveKey('orders');
});

it('adds orders tab to customer edit form', function(): void {
    $customer = mock(Customer::class)->makePartial();
    $form = new Form(resolve(Customers::class), ['model' => $customer, 'context' => 'edit']);
    $form->bindToController();

    $fields = $form->getFields();

    expect($fields['orders']->tab)->toBe('lang:igniter.cart::default.text_tab_orders');
});
