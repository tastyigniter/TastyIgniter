<?php

declare(strict_types=1);

namespace Igniter\User\Auth;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Override;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/auth.php', 'igniter-auth');

        $this->registerGuards();

        AliasLoader::getInstance()->alias('Auth', \Igniter\User\Facades\Auth::class);
        AliasLoader::getInstance()->alias('AdminAuth', AdminAuth::class);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../../config/auth.php' => config_path('igniter-auth.php')], 'igniter-config');
        }

        config()->set('auth.guards', array_merge(config('auth.guards', []), config('igniter-auth.mergeGuards', [])));
        config()->set('auth.providers', array_merge(config('auth.providers', []), config('igniter-auth.mergeProviders', [])));

        $this->configureAuthGuards();

        $this->configureAuthProvider();

        $this->configureGateCallback();

        $this->app->booted(function(): void {
            (new Middleware)->redirectTo(
                fn(): string => route(Igniter::runningInAdmin() ? 'igniter.admin.login' : 'igniter.theme.account.login'),
                fn(): string => route(Igniter::runningInAdmin() ? 'igniter.admin.dashboard' : 'igniter.theme.account.account'),
            );
        });
    }

    protected function registerGuards(): void
    {
        $this->app->singleton('main.auth', fn() => resolve('auth')->guard(config('igniter-auth.guards.web', 'web')));

        $this->app->singleton('admin.auth', fn() => resolve('auth')->guard(config('igniter-auth.guards.admin', 'web')));
    }

    protected function configureAuthGuards()
    {
        Auth::resolved(function($auth): void {
            $auth->extend('igniter-admin', fn($app, $name, array $config): object => $this->createGuard(UserGuard::class, $name, $config, $auth));
        });

        Auth::resolved(function($auth): void {
            $auth->extend('igniter-customer', fn($app, $name, array $config): object => $this->createGuard(CustomerGuard::class, $name, $config, $auth));
        });
    }

    protected function configureAuthProvider()
    {
        Auth::provider('igniter', fn($app, $config): UserProvider => new UserProvider($config));
    }

    protected function configureGateCallback()
    {
        Gate::after(function($user, $ability) {
            if (Igniter::isAdminUser($user)) {
                return $user->hasAnyPermission($ability) === true ? true : null;
            }
        });
    }

    protected function createGuard($guardClass, $name, array $config, $auth): object
    {
        $guard = new $guardClass($name,
            $auth->createUserProvider($config['provider']),
            $this->app['session.store'],
        );

        $guard->setCookieJar($this->app['cookie']);
        $guard->setDispatcher($this->app['events']);
        $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));

        return $guard;
    }
}
