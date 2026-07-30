<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class DiningTableRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter::admin.label_name'),
            'shape' => lang('igniter.reservation::default.dining_tables.label_table_shape'),
            'min_capacity' => lang('igniter.reservation::default.tables.label_min_capacity'),
            'max_capacity' => lang('igniter.reservation::default.tables.label_capacity'),
            'extra_capacity' => lang('igniter.reservation::default.tables.label_extra_capacity'),
            'priority' => lang('igniter.reservation::default.tables.label_priority'),
            'is_enabled' => lang('igniter::admin.label_status'),
            'dining_area_id' => lang('igniter.reservation::default.dining_tables.label_dining_areas'),
            'dining_section_id' => lang('igniter.reservation::default.dining_tables.column_section'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:2,255'],
            'shape' => ['required', 'in:rectangle,round'],
            'min_capacity' => ['required', 'integer', 'min:1', 'lte:max_capacity'],
            'max_capacity' => ['required', 'integer', 'min:1', 'gte:min_capacity'],
            'extra_capacity' => ['sometimes', 'integer'],
            'priority' => ['sometimes', 'integer'],
            'is_enabled' => ['sometimes', 'boolean'],
            'dining_area_id' => ['required', 'integer'],
            'dining_section_id' => ['nullable', 'integer'],
        ];
    }
}
