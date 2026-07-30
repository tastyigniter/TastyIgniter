<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class ReservationRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'table_id' => lang('igniter.reservation::default.column_table'),
            'location_id' => lang('igniter.reservation::default.label_location'),
            'guest_num' => lang('igniter.reservation::default.label_guest_num'),
            'reserve_date' => lang('igniter.reservation::default.label_date'),
            'reserve_time' => lang('igniter.reservation::default.label_time'),
            'first_name' => lang('igniter.reservation::default.label_first_name'),
            'last_name' => lang('igniter.reservation::default.label_last_name'),
            'email' => lang('igniter.reservation::default.label_email'),
            'telephone' => lang('igniter.reservation::default.label_telephone'),
            'comment' => lang('igniter.reservation::default.label_comment'),
        ];
    }

    public function rules(): array
    {
        return [
            'table_id' => ['sometimes', 'required', 'integer'],
            'location_id' => ['required', 'integer'],
            'guest_num' => ['required', 'integer'],
            'reserve_date' => ['required', 'date_format:Y-m-d'],
            'reserve_time' => ['required', 'date_format:H:i'],
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'email' => ['required', 'email:filter', 'max:96'],
            'telephone' => ['required'],
            'comment' => ['max:520'],
        ];
    }
}
