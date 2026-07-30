<?php

declare(strict_types=1);

namespace Igniter\User\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use Override;
use stdClass;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    #[Override]
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $params = new stdClass;
        $params->maxAttempts = $maxAttempts;
        $params->decayMinutes = $decayMinutes;
        $params->prefix = $prefix;

        if ($this->shouldThrottleRequest($request, $params)) {
            return parent::handle($request, $next, $params->maxAttempts, $params->decayMinutes, $params->prefix);
        }

        return $next($request);
    }

    protected function shouldThrottleRequest($request, $params)
    {
        return Event::dispatch('igniter.user.beforeThrottleRequest', [$request, $params], true);
    }
}
