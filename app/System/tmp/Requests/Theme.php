<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Theme extends FormRequest
{
    /**
     * @var \System\Controllers\Themes
     */
    protected $controller;

    public function attributes()
    {
        $attributes = [];

        if (($form = $this->getForm()) && $form->context != 'source') {
            $fieldsConfig = $this->controller->asExtension('FormController')->getFormModel()->getFieldsConfig();
            foreach ($fieldsConfig as $name => $field) {
                if (!array_key_exists('rules', $field))
                    continue;

                $dottedName = implode('.', name_to_array($name));
                $attributes[$dottedName] = $field['label'];
            }
        }

        return $attributes;
    }

    public function rules()
    {
        $rules = [];
        if (($form = $this->getForm()) && $form->context != 'source') {
            $fieldsConfig = $this->controller->asExtension('FormController')->getFormModel()->getFieldsConfig();
            foreach ($fieldsConfig as $name => $field) {
                if (!array_key_exists('rules', $field))
                    continue;

                $dottedName = implode('.', name_to_array($name));
                $rules[$dottedName] = $field['rules'];
            }
        }

        return $rules;
    }

    public function validationData()
    {
        return array_undot($this->getForm()->getSaveData());
    }
}
