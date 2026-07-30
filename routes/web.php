<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\LocationContextController;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Route;

Route::middleware(config('igniter-routes.adminMiddleware', ['web']))
    ->middleware('location.context')
    ->prefix(Igniter::adminUri())
    ->name('admin.location-context.')
    ->group(function (): void {
        Route::get('/locations/select', [LocationContextController::class, 'index'])->name('select');
        Route::post('/locations/switch', [LocationContextController::class, 'switch'])->name('switch');
        Route::post('/locations/global', [LocationContextController::class, 'global'])->name('global');
    });
