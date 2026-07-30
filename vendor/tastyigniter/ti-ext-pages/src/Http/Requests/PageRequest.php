<?php

declare(strict_types=1);

namespace Igniter\Pages\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class PageRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'language_id' => lang('igniter.pages::default.label_language'),
            'title' => lang('igniter.pages::default.label_title'),
            'permalink_slug' => lang('igniter.pages::default.label_permalink_slug'),
            'content' => lang('igniter.pages::default.label_content'),
            'meta_description' => lang('igniter.pages::default.label_meta_description'),
            'meta_keywords' => lang('igniter.pages::default.label_meta_keywords'),
            'metadata.navigation_hidden' => lang('igniter.pages::default.label_navigation'),
            'status' => lang('admin::lang.label_status'),
            'layout' => lang('igniter.pages::default.label_layout'),
        ];
    }

    public function rules(): array
    {
        return [
            'language_id' => ['nullable', 'integer'],
            'title' => ['required', 'min:2', 'max:255'],
            'permalink_slug' => ['alpha_dash', 'max:255'],
            'content' => ['required', 'min:2'],
            'meta_description' => ['nullable'],
            'meta_keywords' => ['nullable'],
            'metadata.navigation_hidden' => ['required'],
            'status' => ['required', 'integer'],
            'layout' => ['nullable', 'alpha_dash'],
        ];
    }
}
