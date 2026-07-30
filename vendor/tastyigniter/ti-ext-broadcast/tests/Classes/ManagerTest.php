<?php

declare(strict_types=1);

namespace Igniter\Broadcast\Tests\Classes;

use Igniter\Admin\Classes\AdminController;
use Igniter\Broadcast\Classes\Manager;
use Igniter\Broadcast\Models\Settings;
use Igniter\Broadcast\Tests\TestBroadcastEvent;
use Igniter\Main\Classes\MainController;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use InvalidArgumentException;
use Mockery;
use ReflectionClass;

function callProtectedMethod($class, string $methodName, array $args = []): mixed
{
    $reflection = new ReflectionClass($class);
    $method = $reflection->getMethod($methodName);

    return $method->invokeArgs($class, $args);
}

it('binds broadcasts for given events', function(): void {
    Event::shouldReceive('listen')->twice();

    resolve(Manager::class)->bindBroadcasts([
        'event1' => 'BroadcastClass1',
        'event2' => 'BroadcastClass2',
    ]);
});

it('binds a single broadcast event', function(): void {
    Event::shouldReceive('listen')->with('event1', Mockery::on(function($callback): true {
        $callback();

        return true;
    }))->once();
    Event::shouldReceive('dispatch')->once();

    resolve(Manager::class)->bindBroadcast('event1', TestBroadcastEvent::class);
});

it('registers broadcast settings in application config', function(): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('resolving')->with(BroadcastManager::class, Mockery::on(function($callback): true {
        $callback();

        return true;
    }))->once();

    Settings::set([
        'provider' => 'reverb',
        'secret' => 'secret',
        'app_id' => '123',
        'key' => '123',
        'encrypted' => '1',
        'reverb_host' => '0.0.0.0',
        'reverb_port' => '123',
        'reverb_scheme' => 'https',
        'reverb_app_id' => '123',
        'reverb_key' => '123',
        'reverb_secret' => 'secret',
    ]);

    resolve(Manager::class)->register($app);

    expect(config('broadcasting.default'))->toEqual('reverb')
        ->and(config('broadcasting.connections.pusher.key'))->toEqual('123')
        ->and(config('broadcasting.connections.pusher.secret'))->toEqual('secret')
        ->and(config('broadcasting.connections.pusher.app_id'))->toEqual('123')
        ->and(config('broadcasting.connections.pusher.options.cluster'))->toEqual(null)
        ->and(config('broadcasting.connections.pusher.options.useTLS'))->toBeTrue()
        ->and(config('broadcasting.connections.reverb.key'))->toEqual('123')
        ->and(config('broadcasting.connections.reverb.secret'))->toEqual('secret')
        ->and(config('broadcasting.connections.reverb.app_id'))->toEqual('123')
        ->and(config('broadcasting.connections.reverb.options.host'))->toEqual('0.0.0.0')
        ->and(config('broadcasting.connections.reverb.options.port'))->toEqual(123)
        ->and(config('broadcasting.connections.reverb.options.scheme'))->toEqual('https')
        ->and(config('broadcasting.connections.reverb.options.useTLS'))->toBeTrue();
});

it('boots and binds broadcasts if configured', function(): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('providerIsLoaded')->andReturn(false);
    Settings::set([
        'secret' => 'secret',
        'app_id' => '123',
        'key' => '123',
    ]);
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerEventBroadcasts')->andReturn([
        [
            'event1' => TestBroadcastEvent::class,
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    Broadcast::shouldReceive('routes')->once();
    Broadcast::shouldReceive('channel')->with('admin.users.{userId}', Mockery::on(function($callback): true {
        $user = Mockery::mock(User::class)->makePartial();
        $callback($user, 1);

        return true;
    }), ['guards' => ['web', 'igniter-admin']]);
    Broadcast::shouldReceive('channel')->with('main.users.{userId}', Mockery::on(function($callback): true {
        $customer = Mockery::mock(Customer::class)->makePartial();
        $callback($customer, 1);

        return true;
    }), ['guards' => ['web', 'igniter-customer']]);

    resolve(Manager::class)->boot($app);

    AdminController::extend(function(AdminController $controller): void {
        $controller->fireEvent('controller.beforeRemap');
    });

    MainController::extend(function(MainController $controller): void {
        $controller->fireEvent('controller.beforeRemap');
    });
});

it('does not boot if not configured', function(): void {
    Settings::clearInternalCache();
    $app = Mockery::mock(Application::class);

    Event::shouldReceive('dispatch');
    Event::shouldReceive('listen')->never();
    Broadcast::shouldReceive('routes')->never();
    Broadcast::shouldReceive('channel')->never();

    resolve(Manager::class)->boot($app);
});

it('dispatches broadcast event', function(): void {
    $broadcastClass = TestBroadcastEvent::class;
    $params = ['user' => null];

    Event::shouldReceive('dispatch')->once()->with(Mockery::type($broadcastClass));

    resolve(Manager::class)->dispatch($broadcastClass, $params);
});

it('throws exception if broadcast class does not exist', function(): void {
    $broadcastClass = 'NonExistentClass';
    $params = ['param1', 'param2'];

    expect(fn() => resolve(Manager::class)->dispatch($broadcastClass, $params))
        ->toThrow(InvalidArgumentException::class);
});

it('adds assets to admin controller', function(): void {
    $controller = new AdminController;
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('receivesBroadcastNotificationsOn')->andReturn('channel');
    AdminAuth::shouldReceive('isLogged')->andReturn(true);
    AdminAuth::shouldReceive('user')->andReturn($user);

    Assets::shouldReceive('putJsVars')->once();
    Assets::shouldReceive('addJs')->times(2);

    callProtectedMethod(new Manager, 'addAssetsToController', [$controller]);
});

it('adds assets to main controller', function(): void {
    $controller = new MainController;
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('receivesBroadcastNotificationsOn')->andReturn('channel');
    Auth::shouldReceive('isLogged')->andReturn(true);
    Auth::shouldReceive('user')->andReturn($customer);

    Assets::shouldReceive('putJsVars')->once();
    Assets::shouldReceive('addJs')->times(2);

    callProtectedMethod(new Manager, 'addAssetsToController', [$controller]);
});
