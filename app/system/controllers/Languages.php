<?php namespace System\Controllers;

use AdminMenu;

class Languages extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Languages_model',
            'title'        => 'lang:system::lang.languages.text_title',
            'emptyMessage' => 'lang:system::lang.languages.text_empty',
            'defaultSort'  => ['language_id', 'DESC'],
            'configFile'   => 'languages_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::lang.languages.text_form_name',
        'model'      => 'System\Models\Languages_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
            'redirect' => 'languages',
        ],
        'delete'     => [
            'redirect' => 'languages',
        ],
        'configFile' => 'languages_model',
    ];

    protected $requiredPermissions = 'Site.Languages';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('languages', 'localisation');
    }

    public function formExtendFields($form, $fields)
    {
        $file = input('file');
        $namespace = input('namespace');

        if (!$field = $form->getField('file'))
            return;

        if (!$namespace OR !$file OR !$form->model->exists) {
            $form->removeField($field->fieldName);

            return;
        }

        flash()->warning(lang('system::lang.languages.alert_save_changes'));

        $field->label = $namespace;
        $field->options = $form->model->getTranslations($file, $namespace);

        $field->hidden = FALSE;
    }

    public function formAfterUpdate($model)
    {
        $file = input('file');
        $namespace = input('namespace');
        $translations = post('Language.file');
        if (!$translations OR !is_array($translations))
            return;

        $model->updateTranslations($file, $namespace, $translations);
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['name', 'lang:system::lang.languages.label_name', 'required|min:2|max:32'],
            ['code', 'lang:system::lang.languages.label_code', 'required|min:2|max:32'],
            ['image', 'lang:system::lang.languages.label_image', 'min:2|max:32'],
            ['idiom', 'lang:system::lang.languages.label_idiom', 'required|min:2|max:32'.
                ((!$model->exists) ? '|unique:languages,idiom' : '')],
            ['can_delete', 'lang:system::lang.languages.label_can_delete', 'required|integer'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
            ['file.*', 'lang:system::lang.languages.text_tab_edit_file', 'sometimes|max:1000'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}