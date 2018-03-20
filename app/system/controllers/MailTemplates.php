<?php namespace System\Controllers;

use AdminMenu;
use Exception;
use System\Models\Mail_layouts_model;

class MailTemplates extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Mail_templates_model',
            'title'        => 'lang:system::mail_templates.text_template_title',
            'emptyMessage' => 'lang:system::mail_templates.text_empty',
            'defaultSort'  => ['date_updated', 'DESC'],
            'configFile'   => 'mail_templates_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::mail_templates.text_form_name',
        'model'      => 'System\Models\Mail_templates_model',
        'create'     => [
            'title'         => 'lang:system::mail_templates.text_new_template_title',
            'redirect'      => 'mail_templates/edit/{template_data_id}',
            'redirectClose' => 'mail_templates',
        ],
        'edit'       => [
            'title'         => 'lang:system::mail_templates.text_edit_template_title',
            'redirect'      => 'mail_templates/edit/{template_data_id}',
            'redirectClose' => 'mail_templates',
        ],
        'preview'    => [
            'title'    => 'lang:system::mail_templates.text_preview_template_title',
            'redirect' => 'mail_templates/preview/{template_data_id}',
        ],
        'delete'     => [
            'redirect' => 'mail_templates',
        ],
        'configFile' => 'mail_templates_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_layouts', 'design');
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['subject', 'lang:system::mail_templates.label_code', 'required'];

        if ($form->context == 'create') {
            $rules[] = ['title', 'lang:system::mail_templates.label_description', 'required'];
            $rules[] = ['code', 'lang:system::mail_templates.label_code', 'required|min:2|max:32'];
            $rules[] = ['template_id', 'lang:system::mail_templates.label_layout', 'required|integer'];
        }

        $rules[] = ['body', 'lang:system::mail_templates.label_body', 'required'];
        $rules[] = ['plain_body', 'lang:system::mail_templates.label_plain', 'required'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}