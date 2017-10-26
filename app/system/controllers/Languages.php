<?php namespace System\Controllers;

use AdminMenu;
use System\Models\Languages_model;

class Languages extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Languages_model',
            'title'        => 'lang:system::languages.text_title',
            'emptyMessage' => 'lang:system::languages.text_empty',
            'defaultSort'  => ['language_id', 'DESC'],
            'configFile'   => 'languages_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::languages.text_form_name',
        'model'      => 'System\Models\Languages_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
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

    public function edit($context = null, $recordId = null)
    {
        $this->asExtension('FormController')->edit($context, $recordId);

        $model = $this->asExtension('FormController')->getFormModel();

        if ($model->isDefault()) {
            flash()->info(lang('admin::languages.alert_caution_edit'));
        }
    }

    public function index_onSetDefault($context = null)
    {
        $defaultId = post('default');

        if (Languages_model::updateDefault($defaultId)) {
            flash()->success(sprintf(lang('alert_success'), lang('alert_set_default')));
        }

        return $this->refreshList($alias);
    }

    public function formExtendFields($form, $fields)
    {
        $domain = input('domain');
        $file = input('file');

        if (!$field = $form->getField('file'))
            return;

        if (!$domain OR !$file OR !$form->model->exists) {
            $form->removeField($field->fieldName);

            return;
        }

        if (!$fileContent = load_lang_file($file, $form->model->idiom, $domain))
            return;

        flash()->warning(lang('admin::languages.alert_save_changes'));

        $field->options = [];
        foreach ($fileContent as $key => $value) {
            $field->options[$key] = $value;
        }

        $field->hidden = FALSE;
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['name', 'lang:system::languages.label_name', 'required|min:2|max:32'],
            ['code', 'lang:system::languages.label_code', 'required|min:2|max:32'],
            ['image', 'lang:system::languages.label_image', 'min:2|max:32'],
            ['idiom', 'lang:system::languages.label_idiom', 'required|min:2|max:32'.
                ((!$model->exists) ? '|unique:languages,idiom' : '')],
            ['language_to_clone', 'lang:system::languages.label_language', 'required_if:clone_language,1|alpha'],
            ['can_delete', 'lang:system::languages.label_can_delete', 'required|integer'],
            ['status', 'lang:admin::default.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }

//    public function _valid_idiom($str)
//    {
//        $lang_files = list_lang_files($str);
//        if (empty($lang_files['admin']) AND empty($lang_files['main']) AND empty($lang_files['module'])) {
//            $this->form_validation->set_message('_valid_idiom', lang('admin::languages.error_invalid_idiom'));
//
//            return FALSE;
//        } else {                                                                                // else validation is not successful
//            return TRUE;
//        }
//    }
}