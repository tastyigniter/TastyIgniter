<?php

declare(strict_types=1);

namespace Igniter\System\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Igniter\System\Rules\SafeMailTemplateContent;
use Illuminate\Validation\Rule;
use Override;

class MailPartialRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter::admin.label_name'),
            'code' => lang('igniter::system.mail_templates.label_code'),
            'html' => lang('igniter::system.mail_templates.label_html'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['sometimes', 'required', 'regex:/^[a-z-_\.\:]+$/i',
                Rule::unique('mail_partials')->ignore($this->getRecordId(), 'partial_id'),
            ],
            'html' => ['required', 'string', new SafeMailTemplateContent],
            'text' => ['nullable', 'string', new SafeMailTemplateContent],
        ];
    }
}
