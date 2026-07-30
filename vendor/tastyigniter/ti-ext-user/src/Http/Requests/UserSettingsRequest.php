<?php

declare(strict_types=1);

namespace Igniter\User\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class UserSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'allow_registration' => lang('igniter::system.settings.label_allow_registration'),
            'registration_email.*' => lang('igniter::system.settings.label_registration_email'),
        ];
    }

    public function rules(): array
    {
        return [
            'allow_registration' => ['required', 'integer'],
            'registration_email' => ['required', 'array'],
            'registration_email.*' => ['required', 'alpha'],
        ];
    }
}
