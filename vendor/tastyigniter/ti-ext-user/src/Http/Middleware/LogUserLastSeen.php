<?php

declare(strict_types=1);

namespace Igniter\User\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Cache;

class LogUserLastSeen
{
    public function handle($request, Closure $next)
    {
        if (Igniter::hasDatabase()) {
            foreach (['admin.auth', 'main.auth'] as $authAlias) {
                $authService = resolve($authAlias);
                if ($authService->check()) {
                    $cacheKey = 'is-online-'.str_replace('.', '-', $authAlias).'-user-'.$authService->getId();
                    $expireAt = Carbon::now()->addMinutes(5);
                    Cache::remember($cacheKey, $expireAt, fn() => $authService->user()->updateLastSeen(Carbon::now()) ?? true);
                }
            }
        }

        return $next($request);
    }
}
