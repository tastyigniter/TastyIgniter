<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Igniter\Reservation\Http\Requests\ReservationRequest as TastyIgniterAdminReservationRequest;

/**
 * The admin reservation form uses the same guest rule as the API.
 */
class AdminReservationRequest extends TastyIgniterAdminReservationRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['last_name'] = ['nullable', 'string', 'between:1,48'];
        $rules['email'] = ['nullable', 'email:filter', 'max:96'];

        return $rules;
    }
}
