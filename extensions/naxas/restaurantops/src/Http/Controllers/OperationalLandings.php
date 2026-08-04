<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Services\OperationalAccessService;
use Naxas\RestaurantOps\Services\RoleProfileResolver;
use Naxas\RestaurantOps\Support\RoleProfiles;

final class OperationalLandings extends AdminPageController
{
    public function __construct(
        private readonly LocationContextContract $context,
        private readonly RoleProfileResolver $profiles,
        private readonly OperationalAccessService $access,
    ) {
        parent::__construct();
    }

    public function overview(): string
    {
        return $this->render('navigation.overview', 'overview');
    }

    public function headOffice(): string
    {
        return $this->render('navigation.head_office', 'head-office');
    }

    public function branch(): string
    {
        return $this->render('navigation.branch', 'branch');
    }

    public function cashier(): string
    {
        return $this->render('navigation.cashier', 'cashier');
    }

    public function waiter(): string
    {
        return $this->render('navigation.waiter', 'waiter');
    }

    public function kitchen(): string
    {
        return $this->render('navigation.kitchen', 'kitchen');
    }

    private function render(string $titleKey, string $workspace): string
    {
        $user = app('admin.auth')->user();
        $profile = $this->profiles->resolve($user);
        $profileLabel = $profile ? RoleProfiles::PROFILES[$profile]['name'] : 'Customized / non-operational';
        $assigned = $this->context->authorizedLocations()->filter(fn ($location): bool => (bool) $location->location_status);
        $summary = collect(['POS', 'DineIn', 'Waiter', 'Kitchen', 'Shifts', 'Reports'])
            ->filter(fn (string $module): bool => $user->hasPermission('Restaurant.'.$module.'.Access')
                || ($module === 'Reports' && $user->hasPermission('Restaurant.Reports.BranchSales')))->values();

        $title = lang('Naxas.RestaurantOps::default.'.$titleKey);
        $activeLocation = $this->context->current();
        $global = $this->context->isGlobal();

        $modules = collect([
            ['label' => lang('Naxas.RestaurantOps::default.navigation.pos'), 'icon' => 'fa-cash-register', 'route' => 'naxas.restaurantops.pos', 'permission' => 'Restaurant.POS.Access', 'transactional' => true],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.active_orders'), 'icon' => 'fa-receipt', 'route' => 'naxas.restaurantops.orders.active', 'permission' => 'Restaurant.POS.Access', 'transactional' => true],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.held_orders'), 'icon' => 'fa-pause-circle', 'route' => 'naxas.restaurantops.orders.held', 'permission' => 'Restaurant.POS.Order.Recall', 'transactional' => true],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.waiter'), 'icon' => 'fa-concierge-bell', 'route' => 'naxas.restaurantops.waiter', 'permission' => 'Restaurant.Waiter.Access', 'transactional' => true],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.kitchen'), 'icon' => 'fa-utensils', 'route' => 'naxas.restaurantops.kitchen', 'permission' => 'Restaurant.Kitchen.Access', 'transactional' => true],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.shifts'), 'icon' => 'fa-clock', 'route' => 'naxas.restaurantops.shifts.index', 'permission' => 'Restaurant.Shifts.Access', 'transactional' => false],
            ['label' => lang('Naxas.RestaurantOps::default.navigation.menu_operations_settings'), 'icon' => 'fa-sliders-h', 'route' => 'naxas.restaurantops.menu-operations.index', 'permission' => 'Restaurant.MenuConfig.View', 'transactional' => false],
        ])->filter(fn (array $module): bool => $this->access->denial($user, $module['permission']) === null)
            ->map(function (array $module) use ($activeLocation, $global): array {
                $requiresSelection = $module['transactional'] && ($global || ! $activeLocation);
                $module['url'] = route($requiresSelection ? 'naxas.restaurantops.location-context.select' : $module['route']);

                return $module;
            })->values();
        $workspaceAction = $workspace === 'cashier' ? $modules->firstWhere('route', 'naxas.restaurantops.pos') : null;

        $assignedToActive = (bool) $activeLocation && $assigned->contains(fn ($location): bool => $location->getKey() === $activeLocation->getKey());
        $readiness = [
            'staffActive' => (bool) $user->status,
            'locationSelected' => (bool) $activeLocation,
            'assignedToActive' => $assignedToActive,
            'transactionalReady' => (bool) $user->status && $assignedToActive && ! $global,
            'global' => $global,
        ];

        $viewData = [
            'pageTitle' => $title,
            'pageSubtitle' => $workspace === 'overview'
                ? 'Monitor branch context, operational access, and current staff readiness.'
                : 'Your permission-aware Restaurant Operations workspace.',
            'workspace' => $workspace,
            'staffName' => (string) $user->name,
            'operationalProfileLabel' => $profileLabel,
            'staffActive' => $readiness['staffActive'],
            'activeLocation' => $activeLocation,
            'activeLocationLabel' => $global ? 'All locations' : ($activeLocation?->location_name ?? 'Branch not selected'),
            'assignedLocations' => $assigned,
            'assignedLocationCount' => $assigned->count(),
            'accessSummary' => $summary,
            'accessibleModuleCount' => $modules->count(),
            'quickActions' => $modules,
            'workspaceAction' => $workspaceAction,
            'transactionalContextReady' => $readiness['transactionalReady'],
            'globalMode' => $global,
            'readiness' => $readiness,
            'readinessMessages' => $readiness['transactionalReady'] || $global
                ? collect()
                : collect(['Select an active assigned branch to use transactional modules.']),
        ];

        return $this->renderAdminPage(
            'Naxas.RestaurantOps::landing',
            $viewData,
            $title,
            'restaurant-ops-'.($workspace === 'overview' ? 'overview' : $workspace),
        );
    }
}
