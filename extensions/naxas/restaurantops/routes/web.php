<?php

use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Route;
use Naxas\RestaurantOps\Http\Controllers\MenuConfiguration\MenuConfigurations;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\CartItems;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\OrderItemSnapshots;
use Naxas\RestaurantOps\Http\Controllers\OperationalLandings;
use Naxas\RestaurantOps\Http\Controllers\Payments\PosPayments;
use Naxas\RestaurantOps\Http\Controllers\Pos\PosOrders;
use Naxas\RestaurantOps\Http\Controllers\Shifts\CashierShifts;
use Naxas\RestaurantOps\Http\Controllers\Tables\FloorsController;
use Naxas\RestaurantOps\Http\Controllers\Tables\TablesController;

Route::middleware(['web'])
    ->prefix('restaurant-ops/v1')
    ->name('naxas.restaurantops.v1.')
    ->group(function (): void {
        Route::post('/cart/quote', [CartItems::class, 'quote'])->name('cart.quote');
        Route::post('/cart/items', [CartItems::class, 'store'])->name('cart.items.store');
    });

Route::middleware([...config('igniter-routes.adminMiddleware', ['web']), 'location.context'])
    ->prefix(Igniter::adminUri().'/restaurant-ops')
    ->name('naxas.restaurantops.')
    ->group(function (): void {
        Route::get('/', [OperationalLandings::class, 'overview'])->middleware('restaurant.ops.permission:Restaurant.Operations.Access')->name('overview');
        Route::get('/head-office', [OperationalLandings::class, 'headOffice'])->middleware('restaurant.ops.permission:Restaurant.Operations.HeadOfficeDashboard')->name('head-office');
        Route::get('/branch', [OperationalLandings::class, 'branch'])->middleware(['restaurant.ops.permission:Restaurant.Operations.BranchDashboard', 'restaurant.ops.transactional'])->name('branch-operations');
        Route::get('/cashier', [OperationalLandings::class, 'cashier'])->middleware(['restaurant.ops.permission:Restaurant.POS.Access', 'restaurant.ops.transactional'])->name('cashier');
        Route::get('/waiter', [OperationalLandings::class, 'waiter'])->middleware(['restaurant.ops.permission:Restaurant.Waiter.Access', 'restaurant.ops.transactional'])->name('waiter');
        Route::get('/kitchen', [OperationalLandings::class, 'kitchen'])->middleware(['restaurant.ops.permission:Restaurant.Kitchen.Access', 'restaurant.ops.transactional'])->name('kitchen');
        Route::get('/menu-operations-settings', [MenuConfigurations::class, 'catalog'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.View')->name('menu-operations.index');
        Route::get('/menu-operations-settings/{menu}', [MenuConfigurations::class, 'index'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.View')->name('menu-operations.show');
        Route::post('/menu-operations-settings/{menu}/variants', [MenuConfigurations::class, 'storeVariant'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.Variants.Manage')->name('menu-operations.variants.store');
        Route::delete('/menu-operations-settings/{menu}/variants/{variant}', [MenuConfigurations::class, 'archiveVariant'])->middleware('restaurant.ops.permission:Restaurant.MenuConfig.Variants.Manage')->name('menu-operations.variants.archive');
        Route::get('/order-item-snapshots/{orderMenu}', [OrderItemSnapshots::class, 'show'])->middleware('restaurant.ops.permission:Restaurant.Operations.Access')->name('order-item-snapshots.show');
        Route::get('/shifts', [CashierShifts::class, 'index'])->middleware('restaurant.ops.permission:Restaurant.Shifts.Access')->name('shifts.index');
        Route::get('/shifts/mine', [CashierShifts::class, 'mine'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.ViewOwn', 'restaurant.ops.transactional'])->name('shifts.mine');
        Route::get('/shifts/branch-review', [CashierShifts::class, 'branchReview'])->middleware(['restaurant.ops.permission:Restaurant.Shifts.ViewBranch', 'restaurant.ops.transactional'])->name('shifts.branch-review');
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

        Route::get('/tables', [TablesController::class, 'index'])->middleware('restaurant.ops.permission:Restaurant.Tables.Manage')->name('tables.index');
        Route::get('/tables/map', [TablesController::class, 'map'])->middleware(['restaurant.ops.permission:Restaurant.Tables.View', 'restaurant.ops.transactional'])->name('tables.map');
        Route::get('/floors', [FloorsController::class, 'index'])->middleware(['restaurant.ops.permission:Restaurant.Tables.View', 'restaurant.ops.transactional'])->name('floors.index');
        Route::post('/floors', [FloorsController::class, 'store'])->middleware(['restaurant.ops.permission:Restaurant.Floors.Manage', 'restaurant.ops.transactional'])->name('floors.store');
        Route::put('/floors/{floor}', [FloorsController::class, 'update'])->middleware(['restaurant.ops.permission:Restaurant.Floors.Manage', 'restaurant.ops.transactional'])->name('floors.update');
        Route::post('/tables', [TablesController::class, 'store'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Manage', 'restaurant.ops.transactional'])->name('tables.store');
        Route::put('/tables/{table}', [TablesController::class, 'update'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Manage', 'restaurant.ops.transactional'])->name('tables.update');
        Route::post('/tables/{table}/open', [TablesController::class, 'open'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Open', 'restaurant.ops.transactional'])->name('tables.open');
        Route::post('/table-sessions/{session}/guest-count', [TablesController::class, 'guestCount'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Open', 'restaurant.ops.transactional'])->name('table-sessions.guest-count');
        Route::get('/table-sessions/{session}/bill', [TablesController::class, 'bill'])->middleware(['restaurant.ops.permission:Restaurant.Tables.View', 'restaurant.ops.transactional'])->name('table-sessions.bill');
        Route::post('/table-sessions/{session}/bill-request', [TablesController::class, 'billRequest'])->middleware(['restaurant.ops.permission:Restaurant.Tables.BillRequest', 'restaurant.ops.transactional'])->name('table-sessions.bill-request');
        Route::post('/table-sessions/{session}/transfer', [TablesController::class, 'transfer'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Transfer', 'restaurant.ops.transactional'])->name('table-sessions.transfer');
        Route::post('/table-sessions/{session}/merge', [TablesController::class, 'merge'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Merge', 'restaurant.ops.transactional'])->name('table-sessions.merge');
        Route::post('/table-sessions/{session}/split', [TablesController::class, 'split'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Split', 'restaurant.ops.transactional'])->name('table-sessions.split');
        Route::post('/table-sessions/{session}/close', [TablesController::class, 'close'])->middleware(['restaurant.ops.permission:Restaurant.Tables.Close', 'restaurant.ops.transactional'])->name('table-sessions.close');
        Route::get('/pos', [PosOrders::class, 'screen'])->middleware(['restaurant.ops.permission:Restaurant.POS.Access', 'restaurant.ops.transactional'])->name('pos');
        Route::get('/orders/active', [PosOrders::class, 'active'])->middleware(['restaurant.ops.permission:Restaurant.POS.Access', 'restaurant.ops.transactional'])->name('orders.active');
        Route::get('/orders/held', [PosOrders::class, 'held'])->middleware(['restaurant.ops.permission:Restaurant.POS.Order.Recall', 'restaurant.ops.transactional'])->name('orders.held');
        Route::get('/pos/orders', [PosOrders::class, 'index'])->middleware(['restaurant.ops.permission:Restaurant.POS.Access', 'restaurant.ops.transactional'])->name('pos.orders.index');
        Route::post('/pos/orders', [PosOrders::class, 'store'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Create')->name('pos.orders.store');
        Route::get('/pos/orders/{posOrder}', [PosOrders::class, 'show'])->middleware('restaurant.ops.permission:Restaurant.POS.Access')->name('pos.orders.show');
        Route::patch('/pos/orders/{posOrder}', [PosOrders::class, 'update'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.orders.update');
        Route::post('/pos/orders/{posOrder}/items', [PosOrders::class, 'addItem'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.items.store');
        Route::patch('/pos/orders/{posOrder}/items/{item}', [PosOrders::class, 'updateItem'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.items.update');
        Route::delete('/pos/orders/{posOrder}/items/{item}', [PosOrders::class, 'removeItem'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.items.destroy');
        Route::post('/pos/orders/{posOrder}/hold', [PosOrders::class, 'hold'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Hold')->name('pos.orders.hold');
        Route::post('/pos/orders/{posOrder}/recall', [PosOrders::class, 'recall'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Recall')->name('pos.orders.recall');
        Route::post('/pos/orders/{posOrder}/confirm', [PosOrders::class, 'confirm'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Create')->name('pos.orders.confirm');
        Route::post('/pos/orders/{posOrder}/request-kitchen', [PosOrders::class, 'kitchen'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.orders.kitchen');
        Route::post('/pos/orders/{posOrder}/lock-payment', [PosOrders::class, 'payment'])->middleware('restaurant.ops.permission:Restaurant.POS.Order.Edit')->name('pos.orders.payment');
        Route::post('/pos/orders/{posOrder}/discounts', [PosOrders::class, 'discount'])->middleware('restaurant.ops.permission:Restaurant.POS.Discount.Apply')->name('pos.discounts.store');
        Route::post('/pos/orders/{posOrder}/void-requests', [PosOrders::class, 'voidRequest'])->middleware('restaurant.ops.permission:Restaurant.POS.Void.Request')->name('pos.void-requests.store');
        Route::get('/pos/orders/{posOrder}/payment', [PosPayments::class, 'page'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.Create')->name('pos.payments.page');
        Route::post('/pos/orders/{posOrder}/payments/prepare', [PosPayments::class, 'prepare'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.Create')->name('pos.payments.prepare');
        Route::post('/pos/orders/{posOrder}/payments', [PosPayments::class, 'store'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.Create')->name('pos.payments.store');
        Route::get('/pos/orders/{posOrder}/payments/{payment}', [PosPayments::class, 'show'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.View')->name('pos.payments.show');
        Route::post('/pos/orders/{posOrder}/payments/{payment}/reverse-request', [PosPayments::class, 'reverseRequest'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.Reverse.Request')->name('pos.payments.reverse-request');
        Route::post('/pos/orders/{posOrder}/payments/{payment}/reverse-approve', [PosPayments::class, 'reverseApprove'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.Reverse.Approve')->name('pos.payments.reverse-approve');
        Route::get('/pos/orders/{posOrder}/receipt', [PosPayments::class, 'receipt'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.View')->name('pos.receipt.show');
        Route::post('/pos/orders/{posOrder}/receipt/print', [PosPayments::class, 'print'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.View')->name('pos.receipt.print');
        Route::post('/pos/orders/{posOrder}/receipt/reprint', [PosPayments::class, 'reprint'])->middleware('restaurant.ops.permission:Restaurant.POS.Payment.ReprintReceipt')->name('pos.receipt.reprint');
        Route::post('/pos/orders/{posOrder}/cancel', [PosOrders::class, 'cancel'])->middleware('restaurant.ops.permission:Restaurant.POS.Void.Request')->name('pos.orders.cancel');
    });
