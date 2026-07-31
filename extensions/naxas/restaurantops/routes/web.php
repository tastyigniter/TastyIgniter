<?php

use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Route;
use Naxas\RestaurantOps\Http\Controllers\OperationalLandings;

Route::middleware(config('igniter-routes.adminMiddleware', ['web']))
    ->middleware('location.context')
    ->prefix(Igniter::adminUri().'/restaurant-ops')
    ->name('naxas.restaurantops.')
    ->group(function (): void {
        Route::get('/', [OperationalLandings::class, 'overview'])->middleware('restaurant.ops.permission:Restaurant.Operations.Access')->name('overview');
        Route::get('/head-office', [OperationalLandings::class, 'headOffice'])->middleware('restaurant.ops.permission:Restaurant.Operations.HeadOfficeDashboard')->name('head-office');
        Route::get('/branch', [OperationalLandings::class, 'branch'])->middleware(['restaurant.ops.permission:Restaurant.Operations.BranchDashboard', 'restaurant.ops.transactional'])->name('branch');
        Route::get('/cashier', [OperationalLandings::class, 'cashier'])->middleware(['restaurant.ops.permission:Restaurant.POS.Access', 'restaurant.ops.transactional'])->name('cashier');
        Route::get('/waiter', [OperationalLandings::class, 'waiter'])->middleware(['restaurant.ops.permission:Restaurant.Waiter.Access', 'restaurant.ops.transactional'])->name('waiter');
        Route::get('/kitchen', [OperationalLandings::class, 'kitchen'])->middleware(['restaurant.ops.permission:Restaurant.Kitchen.Access', 'restaurant.ops.transactional'])->name('kitchen');
    });
