<?php

declare(strict_types=1);

namespace Igniter\Main\Providers;

use Igniter\Main\Template\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PagicServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::bind('_file_', fn(string $value) => Page::resolveRouteBinding($value));
    }
}
