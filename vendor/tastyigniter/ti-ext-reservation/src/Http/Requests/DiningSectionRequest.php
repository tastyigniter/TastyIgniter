<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class DiningSectionRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'location_id' => lang('igniter::admin.label_location'),
            'name' => lang('igniter::admin.label_name'),
            'priority' => lang('igniter.reservation::default.dining_tables.label_priority'),
            'description' => lang('igniter::admin.label_description'),
            'is_enabled' => lang('igniter.reservation::default.dining_tables.label_is_enabled'),
        ];
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'priority' => ['required', 'integer'],
            'description' => ['string'],
            'is_enabled' => ['is_enabled', 'boolean'],
            'color' => ['nullable', 'string'],
        ];
    }
}
