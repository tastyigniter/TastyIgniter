<?php

declare(strict_types=1);

namespace Igniter\User\Http\Middleware;

use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Override;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request):mixed $next
     * @param string ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    #[Override]
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Igniter::hasDatabase()) {
            return $next($request);
        }

        $guard = config('igniter-auth.guards.admin');

        if (!empty($guard)) {
            $guards[] = $guard;
        }

        return parent::handle($request, $next, ...$guards);
    }
}
