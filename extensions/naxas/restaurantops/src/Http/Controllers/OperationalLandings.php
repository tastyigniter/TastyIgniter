<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Services\OperationalLandingResolver;
use Naxas\RestaurantOps\Services\RoleProfileResolver;
use Naxas\RestaurantOps\Support\RoleProfiles;

final class OperationalLandings
{
    public function __construct(
        private readonly LocationContextContract $context,
        private readonly RoleProfileResolver $profiles,
        private readonly OperationalLandingResolver $landing,
        private readonly AuditLogger $audit,
    ) {}

    public function overview(): View|RedirectResponse
    {
        $user = app('admin.auth')->user();
        if ($route = $this->landing->routeName($user)) {
            $this->audit->info('restaurant_ops.landing_resolved', ['staff_id' => $user->getKey(), 'route' => $route]);

            return redirect()->route($route);
        }

        return $this->render('Operations Overview', 'overview');
    }

    public function headOffice(): View
    {
        return $this->render('Head Office', 'head-office');
    }

    public function branch(): View
    {
        return $this->render('Branch Operations', 'branch');
    }

    public function cashier(): View
    {
        return $this->render('Cashier Workspace', 'cashier');
    }

    public function waiter(): View
    {
        return $this->render('Waiter Workspace', 'waiter');
    }

    public function kitchen(): View
    {
        return $this->render('Kitchen Workspace', 'kitchen');
    }

    private function render(string $title, string $workspace): View
    {
        $user = app('admin.auth')->user();
        $profile = $this->profiles->resolve($user);
        $profileLabel = $profile ? RoleProfiles::PROFILES[$profile]['name'] : 'Customized / non-operational';
        $assigned = $this->context->authorizedLocations()->filter(fn ($location): bool => (bool) $location->location_status);
        $summary = collect(['POS', 'DineIn', 'Waiter', 'Kitchen', 'Shifts', 'Reports'])
            ->filter(fn (string $module): bool => $user->hasPermission('Restaurant.'.$module.'.Access')
                || ($module === 'Reports' && $user->hasPermission('Restaurant.Reports.BranchSales')))->values();

        return view('naxas.restaurantops::landing', compact('title', 'workspace', 'user', 'profileLabel', 'assigned', 'summary') + [
            'activeLocation' => $this->context->current(), 'global' => $this->context->isGlobal(),
        ]);
    }
}
