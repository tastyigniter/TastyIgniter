<?php

namespace System\Controllers;

use AdminMenu;
use ApplicationException;
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
            'defaultSort' => ['template_id', 'DESC'],
            'configFile' => 'mail_templates_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.mail_templates.text_form_name',
        'model' => 'System\Models\Mail_templates_model',
        'request' => 'System\Requests\MailTemplate',
        'create' => [
            'title' => 'lang:system::lang.mail_templates.text_new_template_title',
            'redirect' => 'mail_templates/edit/{template_id}',
            'redirectClose' => 'mail_templates',
        ],
        'edit' => [
            'title' => 'lang:system::lang.mail_templates.text_edit_template_title',
            'redirect' => 'mail_templates/edit/{template_id}',
            'redirectClose' => 'mail_templates',
        ],
        'preview' => [
            'title' => 'lang:system::lang.mail_templates.text_preview_template_title',
            'redirect' => 'mail_templates/preview/{template_id}',
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

    public function onTestTemplate($context, $recordId)
    {
        if (!strlen($recordId))
            throw new ApplicationException('Template id not found');

        if (!$model = $this->formFindModelObject($recordId))
            throw new ApplicationException('Template not found');

        $adminUser = $this->getUser()->staff;

        config()->set('system.suppressTemplateRuntimeNotice', true);

        Mail::send($model->code, [], function ($message) use ($adminUser) {
            $message->to($adminUser->staff_email, $adminUser->staff_name);
        });

        flash()->success(sprintf(lang('system::lang.mail_templates.alert_test_message_sent'), $adminUser->staff_email));

        return [
            '#notification' => $this->makePartial('flash'),
        ];
    }
}
