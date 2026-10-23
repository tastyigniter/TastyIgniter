<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Igniter\Api\ApiResources\Requests\ReservationRequest as TastyIgniterReservationRequest;

/**
 * Table reservations may arrive with no last name and no email.
 * A non-empty email still has to be a real address.
 */
class ApiReservationRequest extends TastyIgniterReservationRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['last_name'] = ['nullable', 'string', 'between:1,48'];
        $rules['email'] = ['nullable', 'email:filter', 'max:96'];

        return $rules;
    }
}
