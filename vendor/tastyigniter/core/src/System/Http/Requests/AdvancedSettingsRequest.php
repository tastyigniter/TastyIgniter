<?php

declare(strict_types=1);

namespace Igniter\System\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class AdvancedSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'enable_request_log' => lang('igniter::system.settings.label_enable_request_log'),
            'maintenance_mode' => lang('igniter::system.settings.label_maintenance_mode'),
            'maintenance_message' => lang('igniter::system.settings.label_maintenance_message'),
            'activity_log_timeout' => lang('igniter::system.settings.label_activity_log_timeout'),
        ];
    }

    public function rules(): array
    {
        return [
            'enable_request_log' => ['required', 'boolean'],
            'maintenance_mode' => ['required', 'boolean'],
            'maintenance_message' => ['required_if:maintenance_mode,1', 'string'],
            'activity_log_timeout' => ['required', 'integer', 'max:999'],
        ];
    }
}
