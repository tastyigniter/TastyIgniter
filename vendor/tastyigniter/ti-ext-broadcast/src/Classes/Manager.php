<?php

declare(strict_types=1);

namespace Igniter\Broadcast\Classes;

use Igniter\Admin\Classes\AdminController;
use Igniter\Broadcast\Models\Settings;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\MainController;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Facades\Auth;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use InvalidArgumentException;

class Manager
{
    public function bindBroadcasts(array $broadcasts): void
    {
        foreach ($broadcasts as $eventCode => $broadcastClass) {
            $this->bindBroadcast($eventCode, $broadcastClass);
        }
    }

    public function bindBroadcast($eventCode, $broadcastClass): void
    {
        Event::listen($eventCode, function() use ($broadcastClass): void {
            $this->dispatch($broadcastClass, func_get_args());
        });
    }

    public function register(Application $app): void
    {
        $app->resolving(BroadcastManager::class, function(): void {
            if (Igniter::hasDatabase() && Settings::isConfigured()) {
                $this->applyConnectionsConfigValues();
            }
        });
    }

    public function boot(Application $app): void
    {
        if (!Igniter::hasDatabase() || !Settings::isConfigured()) {
            return;
        }

        $this->bindBroadcasts(Settings::findEventBroadcasts());

        if (!$app->providerIsLoaded(BroadcastServiceProvider::class)) {
            Broadcast::routes();
        }

        Broadcast::channel(
            'admin.users.{userId}',
            fn($user, $userId): bool => (int)$user->user_id === (int)$userId, ['guards' => ['web', 'igniter-admin']],
        );

        Broadcast::channel(
            'main.users.{userId}',
            fn($user, $userId): bool => (int)$user->customer_id === (int)$userId, ['guards' => ['web', 'igniter-customer']],
        );

        AdminController::extend(function(AdminController $controller): void {
            $controller->bindEvent('controller.beforeRemap', function() use ($controller): void {
                $this->addAssetsToController($controller);
            });
        });

        MainController::extend(function(MainController $controller): void {
            $controller->bindEvent('controller.beforeRemap', function() use ($controller): void {
                $this->addAssetsToController($controller);
            });
        });
    }

    public function dispatch($broadcastClass, $params = [])
    {
        if (!class_exists($broadcastClass)) {
            throw new InvalidArgumentException(sprintf("Event broadcast class '%s' not found.", $broadcastClass));
        }

        return Event::dispatch(new $broadcastClass(...$params));
    }

    /**
     * @param $controller \Igniter\Admin\Classes\AdminController|\Igniter\Main\Classes\MainController
     */
    protected function addAssetsToController($controller)
    {
        $channelName = null;
        if ($controller instanceof AdminController && AdminAuth::isLogged()) {
            $channelName = AdminAuth::user()->receivesBroadcastNotificationsOn();
        } elseif ($controller instanceof MainController && Auth::isLogged()) {
            $channelName = Auth::user()->receivesBroadcastNotificationsOn();
        }

        Assets::putJsVars(['broadcast' => [
            'driver' => config('broadcasting.default'),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
            'pusherEncrypted' => config('broadcasting.connections.pusher.options.encrypted'),
            'pusherAuthUrl' => url('broadcasting/auth'),
            'pusherUserChannel' => $channelName,
            'reverbKey' => config('broadcasting.connections.reverb.key'),
            'reverbHost' => config('broadcasting.connections.reverb.options.host'),
            'reverbPort' => config('broadcasting.connections.reverb.options.port'),
            'reverbForceTLS' => config('broadcasting.connections.reverb.options.useTLS'),
        ]]);

        $controller->addJs('igniter.broadcast::/js/vendor.js', 'broadcast-vendor-js');
        $controller->addJs('igniter.broadcast::/js/broadcast.js', 'broadcast-js');
    }

    protected function applyConnectionsConfigValues(): void
    {
        config()->set('broadcasting.default', Settings::get('provider', 'pusher'));

        $pusherConfig = config('broadcasting.connections.pusher');
        config()->set('broadcasting.connections.pusher', array_merge($pusherConfig, array_filter([
            'app_id' => Settings::get('app_id'),
            'key' => Settings::get('key'),
            'secret' => Settings::get('secret'),
            'options' => [
                'cluster' => Settings::get('cluster'),
                'useTLS' => (bool)Settings::get('encrypted'),
            ],
        ])));

        $reverbConfig = config('broadcasting.connections.reverb');
        config()->set('broadcasting.connections.reverb', array_merge($reverbConfig, array_filter([
            'app_id' => Settings::get('reverb_app_id'),
            'key' => Settings::get('reverb_key'),
            'secret' => Settings::get('reverb_secret'),
            'options' => [
                'host' => Settings::get('reverb_host', 'localhost'),
                'port' => Settings::get('reverb_port', 443),
                'scheme' => Settings::get('reverb_scheme', 'https'),
                'useTLS' => Settings::get('reverb_scheme') === 'https',
            ],
        ])));
    }
}
