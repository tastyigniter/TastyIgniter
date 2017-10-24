<?php namespace System\Controllers;

use AdminMenu;
use Exception;
use System\Models\Mail_templates_model;
use Template;

class MailTemplates extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Mail_templates_data_model',
            'title'        => 'lang:system::mail_templates.text_title',
            'emptyMessage' => 'lang:system::mail_templates.text_empty',
            'defaultSort'  => ['template_id', 'DESC'],
            'configFile'   => 'mail_templates_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::mail_templates.text_form_name',
        'model'      => 'System\Models\Mail_templates_data_model',
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
        'configFile' => 'mail_templates_data_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public $defaultTemplate;

    public function __construct()
    {
        parent::__construct();

        $this->defaultTemplate = Mail_templates_model::$defaultTemplateId;

        AdminMenu::setContext('mail_templates', 'design');
    }

    public function edit($context, $recordId = null)
    {
        try {
            $this->asExtension('FormController')->edit($context, $recordId);

            $model = $this->getFormModel();
            if ($model->template_id == $this->defaultTemplate) {
                flash()->set('info', lang('admin::mail_templates.alert_caution_edit'));
            }

            $this->widgets['toolbar']->bindEvent('toolbar.extendButtons', function ($toolbar) use ($model) {
                $toolbar->mergeAttributes('back', [
                    'href' => parse_values($model->toArray(), 'mail_layouts/edit/{template_id}'),
                ]);
            });
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function formExtendFields($formWidget)
    {
        foreach ($formWidget->getFields() as $field) {
            switch ($formWidget->context) {
                case 'edit':
                case 'preview':
                    if (in_array($field->fieldName, ['code', 'title', 'template_id']))
                        $field->disabled = TRUE;
                    break;
            }
        }
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['subject', 'lang:system::mail_templates.label_code', 'required'];

        if ($form->context == 'create') {
            $rules[] = ['title', 'lang:system::mail_templates.label_name', 'required'];
            $rules[] = ['code', 'lang:system::mail_templates.label_code', 'required|min:2|max:32'];
            $rules[] = ['template_id', 'lang:system::mail_templates.label_layout', 'required|integer'];
        }

        $rules[] = ['body', 'lang:system::mail_templates.label_layout', 'required'];
        $rules[] = ['plain_body', 'lang:system::mail_templates.label_plain_layout', 'required'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}