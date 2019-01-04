<?php namespace System\Controllers;

use AdminMenu;
use System\Models\Mail_templates_model;

class MailLayouts extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Mail_layouts_model',
            'title' => 'lang:system::lang.mail_templates.text_title',
            'emptyMessage' => 'lang:system::lang.mail_templates.text_empty',
            'defaultSort' => ['template_id', 'DESC'],
            'configFile' => 'mail_layouts_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.mail_templates.text_form_name',
        'model' => 'System\Models\Mail_layouts_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'mail_layouts/edit/{template_id}',
            'redirectClose' => 'mail_layouts',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'mail_layouts/edit/{template_id}',
            'redirectClose' => 'mail_layouts',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'mail_layouts',
        ],
        'delete' => [
            'redirect' => 'mail_layouts',
        ],
        'configFile' => 'mail_layouts_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_templates', 'design');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Admin.MailTemplates.Manage'))
            Mail_templates_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function formExtendFields($form)
    {
        if ($form->context != 'create') {
            $field = $form->getField('code');
            $field->disabled = TRUE;
        }
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['name', 'lang:system::lang.mail_templates.label_name', 'required|min:2|max:32'];
        $rules[] = ['language_id', 'lang:system::lang.mail_templates.label_language', 'required|integer'];

        $rules[] = ['status', 'lang:admin::lang.label_status', 'required|integer'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}