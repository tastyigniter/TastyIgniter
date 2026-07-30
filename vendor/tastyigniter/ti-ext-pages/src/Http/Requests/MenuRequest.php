<?php

declare(strict_types=1);

namespace Igniter\Pages\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MenuRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'theme_code' => lang('igniter.pages::default.menu.label_theme'),
            'name' => lang('admin::lang.label_name'),
            'code' => lang('igniter.pages::default.menu.label_code'),
            'items' => lang('igniter.pages::default.menu.text_menu_items'),
        ];
    }

    public function rules(): array
    {
        return [
            'theme_code' => ['sometimes', 'required', 'alpha_dash'],
            'name' => ['required', 'string'],
            'code' => ['required', 'alpha_dash'],
            'items' => ['sometimes', 'required', 'array'],
        ];
    }
}
