<?php

namespace App\Providers;

use App\Http\Requests\AdminReservationRequest;
use App\Http\Requests\ApiReservationRequest;
use App\Http\Requests\OrderRequest;
use Igniter\Api\ApiResources\Requests\OrderRequest as TastyIgniterOrderRequest;
use Igniter\Api\ApiResources\Requests\ReservationRequest as TastyIgniterReservationRequest;
use Igniter\Cart\Models\Order;
use Igniter\Reservation\Http\Requests\ReservationRequest as TastyIgniterAdminReservationRequest;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TastyIgniterOrderRequest::class, OrderRequest::class);
        $this->app->bind(TastyIgniterReservationRequest::class, ApiReservationRequest::class);
        $this->app->bind(TastyIgniterAdminReservationRequest::class, AdminReservationRequest::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $blankGuestFields = function ($model): void {
            foreach (['last_name', 'email'] as $field) {
                if ($model->{$field} === null) {
                    $model->{$field} = '';
                }
            }
        };

        Order::saving($blankGuestFields);
        Reservation::saving($blankGuestFields);
    }
}
