<?php

declare(strict_types=1);

namespace Igniter\User\Classes;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\User\Http\Controllers\Login;
use Igniter\User\Http\Controllers\Logout;
use Illuminate\Routing\Router;

class RouteRegistrar
{
    public function __construct(protected Router $router) {}

    public function all(): void
    {
        $this->router
            ->middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.adminDomain'))
            ->prefix(Igniter::adminUri())
            ->group(function(Router $router): void {
                $router->controller(Login::class)->group(function(Router $router): void {
                    $router->any('/', 'index')->name('igniter.admin');
                    $router->any('/login', 'index')->name('igniter.admin.login');
                    $router->any('/login/reset/{slug?}', 'reset')->name('igniter.admin.reset');
                });
                $router->controller(Logout::class)->group(function(Router $router): void {
                    $router->any('/logout', 'index')->name('igniter.admin.logout');
                });
            });
    }
}
