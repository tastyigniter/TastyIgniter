<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class OrderStatusRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'status_id' => lang('igniter::admin.label_status'),
            'comment' => lang('igniter::admin.statuses.label_comment'),
            'notify' => lang('igniter::admin.statuses.label_notify'),

            'assignee_group_id' => lang('igniter::admin.statuses.label_assignee_group'),
            'assignee_id' => lang('igniter::admin.statuses.label_assignee'),
        ];
    }

    public function rules(): array
    {
        return [
            'status_id' => ['sometimes', 'required', 'integer', 'exists:statuses'],
            'comment' => ['nullable', 'string', 'max:1500'],
            'notify' => ['sometimes', 'required', 'boolean'],

            'assignee_group_id' => ['sometimes', 'required', 'integer', 'exists:admin_user_groups,user_group_id'],
            'assignee_id' => ['integer', 'exists:admin_users,user_id'],
        ];
    }
}
