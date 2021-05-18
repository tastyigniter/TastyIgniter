<?php

namespace System\Controllers;

use AdminMenu;

class MailPartials extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Mail_partials_model',
            'title' => 'lang:system::lang.mail_templates.text_partial_title',
            'emptyMessage' => 'lang:system::lang.mail_templates.text_empty',
            'defaultSort' => ['partial_id', 'DESC'],
            'configFile' => 'mail_partials_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.mail_templates.text_partial_form_name',
        'model' => 'System\Models\Mail_partials_model',
        'request' => 'System\Requests\MailPartial',
        'create' => [
            'title' => 'lang:system::lang.mail_templates.text_new_partial_title',
            'redirect' => 'mail_partials/edit/{partial_id}',
            'redirectClose' => 'mail_partials',
            'redirectNew' => 'mail_partials/create',
        ],
        'edit' => [
            'title' => 'lang:system::lang.mail_templates.text_edit_partial_title',
            'redirect' => 'mail_partials/edit/{partial_id}',
            'redirectClose' => 'mail_partials',
            'redirectNew' => 'mail_partials/create',
        ],
        'preview' => [
            'title' => 'lang:system::lang.mail_templates.text_preview_partial_title',
            'redirect' => 'mail_partials',
        ],
        'delete' => [
            'redirect' => 'mail_partials',
        ],
        'configFile' => 'mail_partials_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_templates', 'design');
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
}
