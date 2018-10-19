<?php namespace System\Controllers;

use AdminMenu;
use Mail;
use System\Models\Mail_templates_model;

class MailTemplates extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Mail_templates_model',
            'title' => 'lang:system::lang.mail_templates.text_template_title',
            'emptyMessage' => 'lang:system::lang.mail_templates.text_empty',
            'defaultSort' => ['date_updated', 'DESC'],
            'configFile' => 'mail_templates_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.mail_templates.text_form_name',
        'model' => 'System\Models\Mail_templates_model',
        'create' => [
            'title' => 'lang:system::lang.mail_templates.text_new_template_title',
            'redirect' => 'mail_templates/edit/{template_data_id}',
            'redirectClose' => 'mail_templates',
        ],
        'edit' => [
            'title' => 'lang:system::lang.mail_templates.text_edit_template_title',
            'redirect' => 'mail_templates/edit/{template_data_id}',
            'redirectClose' => 'mail_templates',
        ],
        'preview' => [
            'title' => 'lang:system::lang.mail_templates.text_preview_template_title',
            'redirect' => 'mail_templates/preview/{template_data_id}',
        ],
        'delete' => [
            'redirect' => 'mail_templates',
        ],
        'configFile' => 'mail_templates_model',
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

    public function formBeforeSave($model)
    {
        $model->is_custom = TRUE;
    }

    public function formAfterSave($model)
    {
        if (post('test') != 1)
            return;

        $adminUser = $this->getUser()->staff;

        Mail::send($model->code, [], function ($message) use ($adminUser) {
            $message->to($adminUser->staff_email, $adminUser->staff_name);
        });

        flash()->success(sprintf(lang('system::lang.mail_templates.alert_test_message_sent'), $adminUser->staff_email));
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['template_id', 'lang:system::lang.mail_templates.label_layout', 'integer'];
        $rules[] = ['label', 'lang:system::lang.mail_templates.label_description', 'required'];
        $rules[] = ['subject', 'lang:system::lang.mail_templates.label_code', 'required'];

        if ($form->context == 'create') {
            $rules[] = ['code', 'lang:system::lang.mail_templates.label_code', 'required|min:2|max:32'];
        }

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}