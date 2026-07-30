<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useBootstrap();

        Paginator::defaultView('igniter.system::_partials/pagination/default');
        Paginator::defaultSimpleView('igniter.system::_partials/pagination/simple_default');

        Paginator::currentPathResolver(fn() => url()->current());

        Paginator::currentPageResolver(function($pageName = 'page') {
            $page = Request::get($pageName);

            return filter_var($page, FILTER_VALIDATE_INT) !== false && (int)$page >= 1 ? $page : 1;
        });
    }
}
