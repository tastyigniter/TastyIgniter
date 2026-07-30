<?php

declare(strict_types=1);

namespace Igniter\Pages\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MenuItemRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'title' => lang('igniter.pages::default.menu.label_title'),
            'type' => lang('igniter.pages::default.menu.label_type'),
            'url' => lang('igniter.pages::default.menu.label_url'),
            'reference' => lang('igniter.pages::default.menu.label_reference'),
            'parent_id' => lang('igniter.pages::default.menu.label_parent_id'),
            'description' => lang('admin::lang.label_description'),
            'code' => lang('igniter.pages::default.menu.label_code'),
            'config.extraAttributes' => lang('igniter.pages::default.menu.label_attributes'),
        ];
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'type' => ['required', 'string'],
            'url' => ['required_if:type,url', 'nullable', 'string'],
            'reference' => ['nullable', 'regex:/^[\w.\-]+$/'],
            'parent_id' => ['nullable', 'integer'],
            'description' => ['nullable', 'string', 'max:500'],
            'code' => ['nullable', 'alpha_dash'],
            'config.extraAttributes' => ['string'],
        ];
    }
}
