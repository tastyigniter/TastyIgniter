<?php

namespace Admin\Middleware;

use Admin\Facades\AdminAuth;
use Admin\Models\Users_model;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;

class LogUserLastSeen
{
    public function handle($request, Closure $next)
    {
        if (AdminAuth::check()) {
            $expireAt = Carbon::now()->addMinutes(2);
            Cache::remember('is-online-staff-'.AdminAuth::getId(), $expireAt, function () {
                $expireAt = Carbon::now()->addMinutes(5);
                Users_model::where('user_id', AdminAuth::getId())->update([
                    'last_seen' => $expireAt,
                ]);

                return $expireAt;
            });
        }

        return $next($request);
    }
}