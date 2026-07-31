<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Naxas\RestaurantOps\Services\OperationalAccessService;
use Symfony\Component\HttpFoundation\Response;

final class RequiresTransactionalLocation
{
    public function __construct(private readonly OperationalAccessService $access) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($denial = $this->access->denial(app('admin.auth')->user(), 'Restaurant.Operations.Access', true)) {
            [$code, $message, $status] = $denial;
            if ($request->expectsJson()) {
                return response()->json(['error' => compact('code', 'message')], $status);
            }
            abort(403, $message);
        }

        return $next($request);
    }
}
