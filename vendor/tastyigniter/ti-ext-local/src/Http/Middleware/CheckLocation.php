<?php

declare(strict_types=1);

namespace Igniter\Local\Http\Middleware;

use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Facades\Location;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Http\Request;

class CheckLocation
{
    public function handle(Request $request, Closure $next)
    {
        $location = null;
        if (Igniter::runningInAdmin()) {
            $location = $this->checkAdminLocation();
        } elseif (Igniter::hasDatabase()) {
            $location = Location::currentOrDefault();
        }

        if (!is_null($location) && !$request->route()->hasParameter('location')) {
            $request->route()->setParameter('location', $location->permalink_slug);
        }

        if (Igniter::runningInAdmin() || !$location) {
            return $next($request);
        }

        $locationParam = $request->route()->parameter('location');
        if ($locationParam && $locationParam !== $location->permalink_slug) {
            return redirect()->to(page_url('home'));
        }

        if ($locationParam && !$location->isEnabled() && !AdminAuth::getUser()?->hasPermission('Admin.Locations')) {
            flash()->error(lang('igniter.local::default.alert_location_required'));

            return redirect()->to(page_url('home'));
        }

        return $next($request);
    }

    protected function checkAdminLocation()
    {
        if (!AdminAuth::check() || !$location = Location::current()) {
            return null;
        }

        // @phpstan-ignore method.notFound
        if (!AdminAuth::user()->isAssignedLocation($location)) {
            return null;
        }

        return $location;
    }
}
