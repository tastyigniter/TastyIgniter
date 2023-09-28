<?php

namespace Admin\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class LogUserLastSeen
{
    public function handle($request, Closure $next)
    {
        if (App::hasDatabase()) {
            foreach (['admin.auth', 'auth'] as $authService) {
                if (App::hasDatabase() && resolve($authService)->check()) {
                    $cacheKey = 'is-online-'.str_replace('.', '-', $authService).'-user-'.resolve($authService)->getId();
                    $expireAt = Carbon::now()->addMinutes(2);
                    Cache::remember($cacheKey, $expireAt, function () use ($authService) {
                        return resolve($authService)->user()->updateLastSeen(Carbon::now());
                    });
                }
            }
        }

        return $next($request);
    }
}
