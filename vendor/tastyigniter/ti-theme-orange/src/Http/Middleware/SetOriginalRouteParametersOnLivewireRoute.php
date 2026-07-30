<?php

declare(strict_types=1);

namespace Igniter\Orange\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Livewire\Livewire;

class SetOriginalRouteParametersOnLivewireRoute
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->route()) {
            return $next($request);
        }

        if (Livewire::isLivewireRequest() && ($originalParams = $request->route()->parameters())) {
            foreach ($originalParams as $key => $value) {
                request()->route()->setParameter($key, $value);
            }
        }

        return $next($request);
    }
}
