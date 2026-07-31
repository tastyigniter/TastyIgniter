<?php

use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Route;
use Naxas\RestaurantOps\Http\Controllers\MenuConfiguration\MenuConfigurations;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\CartItems;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\OrderItemSnapshots;
use Naxas\RestaurantOps\Http\Controllers\OperationalLandings;
use Naxas\RestaurantOps\Http\Controllers\Shifts\CashierShifts;

Route::middleware(['web'])
    ->prefix('restaurant-ops/v1')
    ->name('naxas.restaurantops.v1.')
    ->group(function (): void {
        Route::post('/cart/quote', [CartItems::class, 'quote'])->name('cart.quote');
        Route::post('/cart/items', [CartItems::class, 'store'])->name('cart.items.store');
    });

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
        Route::get('/menu-configuration', [MenuConfigurations::class, 'catalog'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.View')->name('menu-configuration.catalog');
        Route::get('/menu-configuration/{menu}', [MenuConfigurations::class, 'index'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.View')->name('menu-configuration');
        Route::post('/menu-configuration/{menu}/variants', [MenuConfigurations::class, 'storeVariant'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.Variants.Manage')->name('menu-configuration.variants.store');
        Route::delete('/menu-configuration/{menu}/variants/{variant}', [MenuConfigurations::class, 'archiveVariant'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.Variants.Manage')->name('menu-configuration.variants.archive');
        Route::get('/order-item-snapshots/{orderMenu}', [OrderItemSnapshots::class, 'show'])->middleware('restaurant.ops.permission:Restaurant.Operations.Access')->name('order-item-snapshots.show');
        Route::get('/shifts', [CashierShifts::class, 'index'])->middleware('restaurant.ops.permission:Restaurant.Shifts.Access')->name('shifts.index');
        Route::get('/shifts/open', [CashierShifts::class, 'openForm'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Open', 'restaurant.ops.transactional'])->name('shifts.open');
        Route::post('/shifts', [CashierShifts::class, 'store'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Open', 'restaurant.ops.transactional'])->name('shifts.store');
        Route::get('/shifts/{shift}', [CashierShifts::class, 'show'])->middleware('restaurant.ops.permission:Restaurant.Shifts.Access')->name('shifts.show');
        Route::post('/shifts/{shift}/cash-movements', [CashierShifts::class, 'movement'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.CashMovement.Create', 'restaurant.ops.transactional'])->name('shifts.movements.store');
        Route::post('/shifts/{shift}/cash-movements/{movement}/reverse', [CashierShifts::class, 'reverse'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Approve', 'restaurant.ops.transactional'])->name('shifts.movements.reverse');
        Route::post('/shifts/{shift}/request-close', [CashierShifts::class, 'requestClose'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Close', 'restaurant.ops.transactional'])->name('shifts.request-close');
        Route::post('/shifts/{shift}/submit', [CashierShifts::class, 'submit'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Close', 'restaurant.ops.transactional'])->name('shifts.submit');
        Route::post('/shifts/{shift}/approve', [CashierShifts::class, 'approve'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Approve', 'restaurant.ops.transactional'])->name('shifts.approve');
        Route::post('/shifts/{shift}/reject', [CashierShifts::class, 'reject'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.Approve', 'restaurant.ops.transactional'])->name('shifts.reject');
        Route::post('/shifts/{shift}/force-close', [CashierShifts::class, 'forceClose'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.ForceClose', 'restaurant.ops.transactional'])->name('shifts.force-close');
    });
