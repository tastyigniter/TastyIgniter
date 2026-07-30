<?php

declare(strict_types=1);

namespace Igniter\User\Tests;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Automation\Classes\EventManager;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Local\Models\Location;
use Igniter\System\Contracts\StickyNotification;
use Igniter\System\Models\Settings;
use Igniter\User\Extension;
use Igniter\User\Facades\Auth;
use Igniter\User\Http\Requests\UserSettingsRequest;
use Igniter\User\Models\Customer;
use Igniter\User\Models\Notification;
use Igniter\User\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mockery;
use ReflectionClass;

beforeEach(function(): void {
    $this->extension = new Extension(app());
});

it('listens to user register event and broadcasts notification', function(): void {
    Event::fake();
    $customer = Mockery::mock(Customer::class)->makePartial();
    $data = ['key' => 'value'];

    Event::dispatch('igniter.user.register', [$customer, $data]);

    Event::assertDispatched('igniter.user.register', fn($event, $payload): bool => $payload[0] === $customer && $payload[1] === $data);
});

it('extends location model with users relation', function(): void {
    $this->extension->boot();

    expect((new Location)->relation['morphedByMany']['users'])->toBe([User::class, 'name' => 'locationable']);
});

it('registers endBody hook for admin impersonate banner', function(): void {
    Template::shouldReceive('registerHook')->once()->with('endBody', Mockery::on(function($callback): true {
        $view = $callback();
        expect($view->getName())->toBe('igniter.user::_partials.admin_impersonate_banner');

        return true;
    }));

    $this->extension->boot();
});

it('listens to NotificationSent event and deletes old notifications', function(): void {
    $event = Mockery::mock(NotificationSent::class)->makePartial();
    $event->response = Mockery::mock(Notification::class);
    $notification = $event->response;
    $notification->shouldReceive('getKey')->andReturn(1);
    $event->notification = new class implements StickyNotification
    {
        public function databaseType(): string
        {
            return 'type';
        }
    };
    $event->notifiable = Mockery::mock(User::class);
    $notifiable = $event->notifiable;
    $notifiable->shouldReceive('notifications->where->where->delete')->andReturnSelf()->once();
    Event::shouldReceive('listen')->with(NotificationSent::class, Mockery::on(function($callback) use ($event): true {
        $callback($event);

        return true;
    }))->once();
    Event::shouldReceive('listen')->with('igniter.user.beforeThrottleRequest', Mockery::any())->once();
    Event::shouldReceive('listen')->with('igniter.user.register', Mockery::any())->once();

    $this->extension->boot();
});

it('listens to igniter.user.register event and send CustomerRegisteredNotification', function(): void {
    \Illuminate\Support\Facades\Notification::fake();

    Event::shouldReceive('listen')->with(NotificationSent::class, Mockery::any())->once();
    Event::shouldReceive('listen')->with('igniter.user.beforeThrottleRequest', Mockery::any())->once();
    Event::shouldReceive('listen')->with('igniter.user.register', Mockery::on(function($callback): true {
        $customer = Mockery::mock(Customer::class)->makePartial();
        $callback($customer, []);

        return true;
    }))->once();

    $this->extension->boot();
});

it('registers customer statistics card', function(): void {
    $this->extension->boot();

    $reflection = new ReflectionClass(Statistics::class);
    $method = $reflection->getMethod('listCards');

    $cards = $method->invoke(new Statistics(resolve(Menus::class)));

    expect($cards)->toHaveKey('customer')
        ->and($cards['customer']['label'])->toBe('lang:igniter.user::default.text_total_customer')
        ->and($cards['customer']['valueFrom']('customer', null, null, fn($query) => $query))->toBe(0);
});

it('registers user system settings', function(): void {
    $this->extension->registerSystemSettings();
    $settingsItems = (new Settings)->listSettingItems();
    $settingsItem = collect($settingsItems['core'])->firstWhere('code', 'user');

    expect($settingsItem->label)->toBe('lang:igniter.user::default.text_tab_user')
        ->and($settingsItem->description)->toBe('lang:igniter.user::default.text_tab_desc_user')
        ->and($settingsItem->icon)->toBe('fa fa-users-gear')
        ->and($settingsItem->priority)->toBe(2)
        ->and($settingsItem->permissions)->toBe(['Site.Settings'])
        ->and($settingsItem->url)->toBe(admin_url('settings/edit/user'))
        ->and($settingsItem->form)->toBe('igniter.user::/models/usersettings')
        ->and($settingsItem->request)->toBe(UserSettingsRequest::class);
});

it('registers global event parameters when EventManager class exists', function(): void {
    $eventManager = Mockery::mock(EventManager::class);
    app()->instance(EventManager::class, $eventManager);
    $eventManager->shouldReceive('registerCallback')->once()->andReturnUsing(function($callback) use ($eventManager): void {
        $eventManager->shouldReceive('registerGlobalParams')->with(['customer' => Auth::customer()]);
        $callback($eventManager);
    });

    $this->extension->register();
});

it('registers user panel and notifications admin menus when running in admin', function(): void {
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('setUserResolver')->andReturnNull();
    $request->shouldReceive('getScheme')->andReturn('https');
    $request->shouldReceive('root')->andReturn('localhost');
    $request->shouldReceive('route')->andReturnNull();
    $request->shouldReceive('path')->andReturn('admin/dashboard');
    app()->instance('request', $request);

    $this->extension->boot();
    $menuItems = AdminMenu::getMainItems();

    expect($menuItems['notifications'])->not->toBeNull()
        ->and($menuItems['user'])->not->toBeNull();
});

it('does not register user panel and notifications admin menus when not running in admin', function(): void {
    $this->extension->boot();
    $menuItems = AdminMenu::getMainItems();

    expect($menuItems)->not->toHaveKeys(['notifications', 'user']);
});

it('does not define routes when routes are cached', function(): void {
    $app = Mockery::mock(Application::class)->makePartial();
    $app->shouldReceive('routesAreCached')->andReturn(true);
    Container::setInstance($app);
    Route::shouldReceive('group')->never();

    $reflection = new ReflectionClass(Extension::class);
    $method = $reflection->getMethod('defineRoutes');
    $method->invoke($this->extension);
});

it('configures rate limiter', function(): void {
    RateLimiter::shouldReceive('for')->with('web', Mockery::on(function($callback): true {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $request->shouldReceive('user')->andReturnNull();
        expect($callback($request))->toBeInstanceOf(Limit::class);

        return true;
    }))->once();

    $reflection = new ReflectionClass(Extension::class);
    $method = $reflection->getMethod('configureRateLimiting');
    $method->invoke($this->extension);
});

it('extends dashboard charts datasets', function(): void {
    $this->extension->boot();

    $reflection = new ReflectionClass(Charts::class);
    $method = $reflection->getMethod('listSets');

    $result = $method->invoke(new Charts(resolve(Menus::class)));
    $datasets = $result['reports']['sets'];

    expect($datasets)->toHaveKey('customers')
        ->and($datasets['customers']['label'])->toBe('lang:igniter.user::default.text_charts_customers')
        ->and($datasets['customers']['color'])->toBe('#4DB6AC')
        ->and($datasets['customers']['model'])->toBe(Customer::class)
        ->and($datasets['customers']['column'])->toBe('created_at');
});
