<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MealtimeRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'mealtime_name' => lang('igniter.cart::default.mealtimes.label_mealtime_name'),
            'validity' => lang('igniter.cart::default.mealtimes.label_validity'),
            'start_time' => lang('igniter.cart::default.mealtimes.label_start_time'),
            'end_time' => lang('igniter.cart::default.mealtimes.label_end_time'),
            'start_at' => lang('igniter.cart::default.mealtimes.label_start_at'),
            'end_at' => lang('igniter.cart::default.mealtimes.label_end_at'),
            'recurring_every' => lang('igniter.cart::default.mealtimes.label_recurring_every'),
            'recurring_from' => lang('igniter.cart::default.mealtimes.label_recurring_from'),
            'recurring_to' => lang('igniter.cart::default.mealtimes.label_recurring_to'),
            'mealtime_status' => lang('igniter::admin.label_status'),
            'locations.*' => lang('igniter::admin.label_location'),
        ];
    }

    public function rules(): array
    {
        return [
            'mealtime_name' => ['required', 'string', 'between:2,255'],
            'validity' => ['required', 'in:daily,period,recurring'],
            'start_time' => ['nullable', 'required_if:validity,daily', 'date_format:H:i'],
            'end_time' => ['nullable', 'required_if:validity,daily', 'date_format:H:i'],
            'start_at' => ['nullable', 'required_if:validity,period', 'date'],
            'end_at' => ['nullable', 'required_if:validity,period', 'date', 'after:start_date'],
            'recurring_every' => ['nullable', 'required_if:validity,recurring', 'array'],
            'recurring_every.*' => ['nullable', 'required_if:validity,recurring', 'integer'],
            'recurring_from' => ['nullable', 'required_if:validity,recurring', 'date_format:H:i'],
            'recurring_to' => ['nullable', 'required_if:validity,recurring', 'date_format:H:i'],
            'mealtime_status' => ['required', 'boolean'],
            'locations' => ['nullable', 'array'],
            'locations.*' => ['integer'],
        ];
    }
}
