<?php

declare(strict_types=1);

namespace Igniter\Main\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class ThemeRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        if (!$this->isEditFormContext()) {
            return [];
        }

        return collect($this->fields())->mapWithKeys(function($config, string $field): array {
            $dottedName = implode('.', name_to_array($field));

            return [$dottedName => array_get($config, 'label')];
        })->filter()->all();
    }

    public function rules(): array
    {
        if (!$this->isEditFormContext()) {
            return [];
        }

        return $this->prepareRules($this->fields());
    }

    /**
     * Get data to be validated from the request.
     */
    #[Override]
    public function validationData(): array
    {
        return array_undot($this->all());
    }

    protected function isEditFormContext(): bool
    {
        return $this->route()->getController()->getFormContext() === 'edit';
    }

    protected function fields(): array
    {
        return $this->route()->getController()->getFormModel()->getFieldsConfig();
    }

    protected function prepareRules($rules, ?string $parentKey = null): array
    {
        return collect($rules)->mapWithKeys(function($config, $field) use ($parentKey): array {
            if (array_has($config, 'form.fields')) {
                return $this->prepareRules(array_get($config, 'form.fields'), $field);
            }

            if ($parentKey) {
                $field = $parentKey.'.*.'.$field;
            }

            $dottedName = implode('.', name_to_array($field));

            return [$dottedName => array_get($config, 'rules')];
        })->filter()->all();
    }
}
