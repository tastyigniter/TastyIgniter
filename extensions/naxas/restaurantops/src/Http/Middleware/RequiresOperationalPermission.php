<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Naxas\RestaurantOps\Services\OperationalAccessService;
use Symfony\Component\HttpFoundation\Response;

final class RequiresOperationalPermission
{
    public function __construct(private readonly OperationalAccessService $access) {}

    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! app('admin.auth')->check()) {
            return $request->expectsJson()
                ? response()->json(['error' => ['code' => 'authentication_required', 'message' => 'Authentication is required.']], 401)
                : redirect()->guest(route('igniter.admin.login'));
        }

        if ($denial = $this->access->denial(app('admin.auth')->user(), $permission)) {
            return $this->deny($request, ...$denial);
        }

        return $next($request);
    }

    private function deny(Request $request, string $code, string $message, int $status): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => compact('code', 'message')], $status);
        }

        abort($status === 409 ? 403 : $status, $message);
    }
}
