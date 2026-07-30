<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class DiningAreaRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter::admin.label_name'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'between:2,128'],
            'location_id' => ['required'],
        ];
    }
}
