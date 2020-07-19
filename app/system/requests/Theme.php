<?php

namespace System\Requests;

use Illuminate\Contracts\Validation\Validator;
use System\Classes\FormRequest;

class Theme extends FormRequest
{
    /**
     * @var \System\Controllers\Themes
     */
    protected $controller;

    public function rules()
    {
        $form = $this->controller->widgets['form'];
        if ($form->context != 'source') {
            $rules = [];
            $fieldsConfig = $this->controller->asExtension('FormController')->getFormModel()->getFieldsConfig();
            foreach ($fieldsConfig as $name => $field) {
                if (!array_key_exists('rules', $field))
                    continue;

                $dottedName = implode('.', name_to_array($name));
                $rules[] = [$dottedName, $field['label'], $field['rules']];
            }

            return $rules;
        }

        return [
            ['template', 'lang:system::lang.themes.label_template', 'required'],
            ['markup', 'lang:system::lang.themes.text_tab_markup', 'sometimes'],
            ['codeSection', 'lang:system::lang.themes.text_tab_php_section', 'sometimes'],
            ['settings.components.*.alias', 'lang:system::lang.themes.label_component_alias', 'sometimes|required|regex:/^[a-zA-Z\s]+$/'],
            ['settings.title', 'lang:system::lang.themes.label_title', 'sometimes|required|max:160'],
            ['settings.description', 'lang:admin::lang.label_description', 'sometimes|max:255'],
            ['settings.layout', 'lang:system::lang.themes.label_layout', 'sometimes|string'],
            ['settings.permalink', 'lang:system::lang.themes.label_permalink', 'sometimes|required|string'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $form = $this->controller->widgets['form'];
            if ($form->context == 'source' AND $this->controller->wasTemplateModified())
                $validator->errors()->add('markup', lang('system::lang.themes.alert_changes_confirm'));
        });
    }

    public function validationData()
    {
        return array_undot($this->getForm()->getSaveData());
    }
}