<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\LocationContext;
use Closure;
use Illuminate\Http\Request;
use Naxas\RestaurantOps\Services\StaffPreferenceService;
use Symfony\Component\HttpFoundation\Response;

class ResolveLocationContext
{
    public function __construct(protected LocationContext $context, protected StaffPreferenceService $preferences) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! app('admin.auth')->check()) {
            return $this->error($request, 'authentication_required', 'Authentication is required.', 401,
                route('igniter.admin.login'));
        }

        $submittedId = $request->route('location_id') ?? $request->input('location_id');
        if ($submittedId !== null && ! $this->context->canAccess($submittedId)) {
            $this->context->clear();

            return $this->error($request, 'location_forbidden', 'You are not authorized to access that location.', 403);
        }

        if ($this->context->isGlobal() || $this->context->current()) {
            return $next($request);
        }

        $locations = $this->context->authorizedLocations()
            ->filter(fn ($location): bool => $location->location_status || app('admin.auth')->user()->hasPermission('Admin.Locations'));

        if ($locations->count() === 1) {
            $this->context->set($locations->first()->getKey());

            return $next($request);
        }

        if ($locations->count() > 1 && ($defaultId = $this->preferences->defaultLocationId(app('admin.auth')->user()))) {
            $this->context->set($defaultId);

            return $next($request);
        }

        if ($request->routeIs('admin.location-context.*')) {
            return $next($request);
        }

        return $this->error($request, 'location_required', 'Select an active location to continue.', 409,
            route('admin.location-context.select'));
    }

    protected function error(Request $request, string $code, string $message, int $status, ?string $redirect = null): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => ['code' => $code, 'message' => $message]], $status);
        }

        if ($status === 403) {
            abort(403, $message);
        }

        return redirect()->guest($redirect ?? route('admin.location-context.select'));
    }
}
