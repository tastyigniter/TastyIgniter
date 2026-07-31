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

        return $this->render('navigation.overview', 'overview');
    }

    public function headOffice(): View
    {
        return $this->render('navigation.head_office', 'head-office');
    }

    public function branch(): View
    {
        return $this->render('navigation.branch', 'branch');
    }

    public function cashier(): View
    {
        return $this->render('navigation.cashier', 'cashier');
    }

    public function waiter(): View
    {
        return $this->render('navigation.waiter', 'waiter');
    }

    public function kitchen(): View
    {
        return $this->render('navigation.kitchen', 'kitchen');
    }

    private function render(string $titleKey, string $workspace): View
    {
        $user = app('admin.auth')->user();
        $profile = $this->profiles->resolve($user);
        $profileLabel = $profile ? RoleProfiles::PROFILES[$profile]['name'] : 'Customized / non-operational';
        $assigned = $this->context->authorizedLocations()->filter(fn ($location): bool => (bool) $location->location_status);
        $summary = collect(['POS', 'DineIn', 'Waiter', 'Kitchen', 'Shifts', 'Reports'])
            ->filter(fn (string $module): bool => $user->hasPermission('Restaurant.'.$module.'.Access')
                || ($module === 'Reports' && $user->hasPermission('Restaurant.Reports.BranchSales')))->values();

        $title = lang('Naxas.RestaurantOps::default.'.$titleKey);

        return view('Naxas.RestaurantOps::landing', compact('title', 'workspace', 'user', 'profileLabel', 'assigned', 'summary') + [
            'activeLocation' => $this->context->current(), 'global' => $this->context->isGlobal(),
        ]);
    }
}
