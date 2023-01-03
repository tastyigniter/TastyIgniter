<?php

namespace Admin\Middleware;

use Admin\Facades\AdminAuth;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class LogUserLastSeen
{
    public function handle($request, Closure $next)
    {
        if (App::hasDatabase() && AdminAuth::check()) {
            $cacheKey = 'is-online-user-'.AdminAuth::getId();
            $expireAt = Carbon::now()->addMinutes(2);
            Cache::remember($cacheKey, $expireAt, function () {
                return AdminAuth::user()->updateLastSeen(Carbon::now()->addMinutes(5));
            });
        }

        return $next($request);
    }
}
