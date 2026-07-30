<?php

declare(strict_types=1);

namespace Igniter\Main\Http\Middleware;

use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Models\Location;
use Igniter\User\Models\User;
use Illuminate\Http\Request;

class CheckInitialSetup
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Igniter::hasDatabase() && $request->routeIs('igniter.theme.*') && $this->needsInitialSetup()) {
            return redirect(admin_url());
        }

        return $next($request);
    }

    protected function needsInitialSetup(): bool
    {
        return User::query()->doesntExist() || Location::query()->doesntExist();
    }
}
