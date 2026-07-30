<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class LocationSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'location_id' => lang('igniter.local::default.label_location_id'),
        ];
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', 'integer'],
            'item' => ['required', 'string'],
            'data' => ['required', 'array'],
        ];
    }
}
