<?php

declare(strict_types=1);

namespace Igniter\User\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class CustomerGroupRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'group_name' => lang('igniter::admin.label_name'),
            'approval' => lang('igniter.user::default.customer_groups.label_approval'),
            'description' => lang('igniter::admin.label_description'),
        ];
    }

    public function rules(): array
    {
        return [
            'group_name' => ['required', 'string', 'between:2,32',
                Rule::unique('customer_groups')->ignore($this->getRecordId(), 'customer_group_id'),
            ],
            'approval' => ['required', 'boolean'],
            'description' => ['nullable', 'string', 'between:2,512'],
        ];
    }
}
