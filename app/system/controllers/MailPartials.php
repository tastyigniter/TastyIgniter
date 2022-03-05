<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;

class MailPartials extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \System\Models\MailPartial::class,
            'title' => 'lang:system::lang.mail_templates.text_partial_title',
            'emptyMessage' => 'lang:system::lang.mail_templates.text_empty',
            'defaultSort' => ['partial_id', 'DESC'],
            'configFile' => 'mailpartial',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.mail_templates.text_partial_form_name',
        'model' => \System\Models\MailPartial::class,
        'request' => \System\Requests\MailPartial::class,
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
        'configFile' => 'mailpartial',
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
