<?php

declare(strict_types=1);

namespace Igniter\System\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PoweredBy
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (config('igniter-system.sendPoweredByHeader') && $response instanceof Response) {
            $response->header('X-Powered-By', 'TastyIgniter');
        }

        return $response;
    }
}
