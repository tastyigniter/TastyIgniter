<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class ResourceRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter.api::default.label_name'),
            'description' => lang('igniter.api::default.label_description'),
            'endpoint' => lang('igniter.api::default.label_endpoint'),
            'meta.actions' => lang('igniter.api::default.label_actions'),
            'meta.authorization' => lang('igniter.api::default.label_authorization'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:128', 'string'],
            'description' => ['required', 'min:2', 'max:255'],
            'endpoint' => ['max:255', 'regex:/^[a-z0-9\-_\/]+$/i', 'unique:igniter_api_resources,endpoint,'.$this->getRecordId()],
            'meta' => ['array'],
            'meta.actions.*' => ['alpha'],
            'meta.authorization.*' => ['alpha'],
        ];
    }
}
