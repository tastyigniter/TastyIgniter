<?php

declare(strict_types=1);

namespace Igniter\System\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class CountryRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'country_name' => lang('igniter::admin.label_name'),
            'priority' => lang('igniter::system.countries.label_priority'),
            'iso_code_2' => lang('igniter::system.countries.label_iso_code2'),
            'iso_code_3' => lang('igniter::system.countries.label_iso_code3'),
            'format' => lang('igniter::system.countries.label_format'),
            'status' => lang('igniter::admin.label_status'),
        ];
    }

    public function rules(): array
    {
        return [
            'country_name' => ['required', 'string', 'between:2,255'],
            'priority' => ['required', 'integer'],
            'iso_code_2' => ['required', 'string', 'size:2'],
            'iso_code_3' => ['required', 'string', 'size:3'],
            'format' => ['min:2', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }
}
