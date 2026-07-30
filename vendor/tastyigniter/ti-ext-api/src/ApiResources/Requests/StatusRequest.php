<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class StatusRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'comment' => lang('igniter::admin.statuses.label_comment'),
            'notify' => lang('igniter::admin.statuses.label_notify_customer'),
        ];
    }

    public function rules(): array
    {
        return [
            'status_id' => ['required', 'integer', 'exists:statuses,status_id'],
            'comment' => ['nullable', 'string', 'max:500'],
            'notify' => ['nullable', 'boolean'],
        ];
    }
}
