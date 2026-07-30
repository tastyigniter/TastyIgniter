<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Middleware;

use Closure;
use Igniter\Api\Exceptions;
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
     * @throws Exceptions\AuthenticationException
     */
    #[Override]
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $guard = config('igniter-api.guard');

            if (!empty($guard)) {
                $guards[] = $guard;
            }

            return parent::handle($request, $next, ...$guards);
        } catch (AuthenticationException $e) {
            throw new Exceptions\AuthenticationException('Unauthenticated.', $e->guards());
        }
    }
}
