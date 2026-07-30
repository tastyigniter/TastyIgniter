<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class ReservationSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'default_reservation_status' => lang('igniter.reservation::default.label_default_reservation_status'),
            'confirmed_reservation_status' => lang('igniter.reservation::default.label_confirmed_reservation_status'),
            'canceled_reservation_status' => lang('igniter.reservation::default.label_canceled_reservation_status'),
        ];
    }

    public function rules(): array
    {
        return [
            'reservation_email.*' => ['required', 'alpha'],
            'default_reservation_status' => ['required', 'integer'],
            'confirmed_reservation_status' => ['required', 'integer'],
            'canceled_reservation_status' => ['required', 'integer'],
        ];
    }
}
