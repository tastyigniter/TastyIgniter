<?php namespace System\Controllers;

use AdminAuth;
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
            'model'        => 'System\Models\Mail_layouts_model',
            'title'        => 'lang:system::mail_templates.text_title',
            'emptyMessage' => 'lang:system::mail_templates.text_empty',
            'defaultSort'  => ['template_id', 'DESC'],
            'configFile'   => 'mail_layouts_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::mail_templates.text_form_name',
        'model'      => 'System\Models\Mail_layouts_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'mail_layouts/edit/{template_id}',
            'redirectClose' => 'mail_layouts',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'mail_layouts/edit/{template_id}',
            'redirectClose' => 'mail_layouts',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'mail_layouts',
        ],
        'delete'     => [
            'redirect' => 'mail_layouts',
        ],
        'configFile' => 'mail_layouts_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_layouts', 'design');
    }

    public function index()
    {
        if (AdminAuth::hasPermission('Admin.MailTemplates.Manage'))
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
        $rules[] = ['name', 'lang:system::mail_templates.label_name', 'required|min:2|max:32'];
        $rules[] = ['language_id', 'lang:system::mail_templates.label_language', 'required|integer'];

        $rules[] = ['status', 'lang:admin::default.label_status', 'required|integer'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}