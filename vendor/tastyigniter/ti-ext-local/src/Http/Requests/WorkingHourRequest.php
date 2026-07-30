<?php

declare(strict_types=1);

namespace Igniter\Local\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class WorkingHourRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'type' => lang('igniter.local::default.label_schedule_type'),
            'days.*' => lang('igniter.local::default.label_schedule_days'),
            'open' => lang('igniter.local::default.label_schedule_open'),
            'close' => lang('igniter.local::default.label_schedule_close'),
            'timesheet' => lang('igniter.local::default.text_timesheet'),
            'flexible.*.day' => lang('igniter.local::default.label_schedule_days'),
            'flexible.*.hours' => lang('igniter.local::default.label_schedule_hours'),
            'flexible.*.status' => lang('igniter::admin.label_status'),
        ];
    }

    public function rules(): array
    {
        return [
            'type' => ['alpha_dash', 'in:24_7,daily,timesheet,flexible'],
            'days.*' => ['required_if:type,daily', 'integer', 'between:0,7'],
            'open' => ['required_if:type,daily', 'date_format:H:i'],
            'close' => ['required_if:type,daily', 'date_format:H:i'],
            'timesheet' => ['required_if:type,timesheet', 'string'],
            'flexible' => ['required_if:type,flexible', 'array'],
            'flexible.*.day' => ['required_if:type,flexible', 'numeric'],
            'flexible.*.hours' => ['required_if:type,flexible'],
            'flexible.*.status' => ['sometimes', 'required_if:type,flexible', 'boolean'],
        ];
    }
}
