<?php

declare(strict_types=1);

namespace Igniter\User\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UserGroupRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'user_group_name' => lang('igniter::admin.label_name'),
            'description' => lang('igniter::admin.label_description'),
            'auto_assign' => lang('igniter.user::default.user_groups.label_auto_assign'),
            'auto_assign_mode' => lang('igniter.user::default.user_groups.label_assignment_mode'),
            'auto_assign_limit' => lang('igniter.user::default.user_groups.label_load_balanced_limit'),
            'auto_assign_availability' => lang('igniter.user::default.user_groups.label_assignment_availability'),
        ];
    }

    public function rules(): array
    {
        return [
            'user_group_name' => ['required', 'string', 'between:2,255',
                Rule::unique('admin_user_groups')->ignore($this->getRecordId(), 'user_group_id'),
            ],
            'description' => ['string'],
            'auto_assign' => ['required', 'boolean'],
            'auto_assign_mode' => ['required_if:auto_assign,true', 'integer', 'max:2'],
            'auto_assign_limit' => ['required_if:auto_assign_mode,2', 'integer', 'max:99'],
            'auto_assign_availability' => ['required_if:auto_assign,true', 'boolean'],
        ];
    }
}
