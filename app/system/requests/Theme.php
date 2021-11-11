<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Theme extends FormRequest
{
    /**
     * @var \System\Controllers\Themes
     */
    protected $controller;

    public function rules()
    {
        if (($form = $this->getForm()) && $form->context != 'source') {
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

        return [];
    }

    public function validationData()
    {
        return array_undot($this->getForm()->getSaveData());
    }
}
