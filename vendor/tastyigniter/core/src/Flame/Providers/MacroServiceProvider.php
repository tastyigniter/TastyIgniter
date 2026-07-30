<?php

declare(strict_types=1);

namespace Igniter\Flame\Providers;

use Igniter\Flame\Mixins\BlueprintMixin;
use Igniter\Flame\Mixins\RouterMixin;
use Igniter\Flame\Mixins\StringMixin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Str::mixin(new StringMixin);

        Router::mixin(new RouterMixin);

        Blueprint::mixin(new BlueprintMixin);

        Dispatcher::macro('fire', fn($event, $payload = [], $halt = false) => $this->dispatch($event, $payload, $halt));
    }
}
