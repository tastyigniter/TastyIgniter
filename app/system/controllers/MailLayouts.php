<?php namespace System\Controllers;

use AdminAuth;
use Exception;
use System\Models\Mail_templates_data_model;
use System\Models\Mail_templates_model;
use Template;
use AdminMenu;

class MailLayouts extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Mail_templates_model',
            'title'        => 'lang:system::mail_templates.text_title',
            'emptyMessage' => 'lang:system::mail_templates.text_empty',
            'defaultSort'  => ['template_id', 'DESC'],
            'configFile'   => 'mail_templates_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::mail_templates.text_form_name',
        'model'      => 'System\Models\Mail_templates_model',
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
        'configFile' => 'mail_templates_model',
    ];

    protected $requiredPermissions = 'Admin.MailTemplates';

    public $defaultTemplate;

    public function __construct()
    {
        parent::__construct();

        $this->defaultTemplate = Mail_templates_model::$defaultTemplateId;

        AdminMenu::setContext('mail_templates', 'design');
    }

    public function index()
    {
        if (AdminAuth::hasPermission('Admin.MailTemplates.Manage'))
            Mail_templates_data_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function edit($context, $recordId = null)
    {
        if ($recordId == $this->defaultTemplate) {
            $this->alert->info_now(lang('alert_caution_edit'));
        }

        try {
            $this->asExtension('FormController')->edit($context, $recordId);

            $model = $this->getFormModel();
            $this->widgets['toolbar']->bindEvent('toolbar.extendButtons', function ($toolbar) use ($model) {
                $toolbar->mergeAttributes('changes', [
                    'href' => parse_values($model->toArray(), 'mail_layouts/changes/{template_id}'),
                ]);
            });
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function changes($context, $recordId = null)
    {
        try {
            $pageTitle = lang('text_changes_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            Assets::addCss(assets_url('js/summernote/summernote.css'), 'summernote-css');
            Assets::addJs(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

            $model = Mail_templates_model::with(['original'])->findOrNew((int)$recordId);
            $layoutChanges = Mail_templates_data_model::fetchChanges($model->template_id);

            if (!$layoutChanges) {
                flash()->set('success', sprintf(lang('text_no_changes'), $model->name, $model->original->name));
                return $this->redirect('mail_layouts/edit/'.$recordId);
            }

            $this->vars['layoutModel'] = $model;
            $this->vars['layoutParentModel'] = $model->original;
            $this->vars['layoutChanges'] = $layoutChanges;
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onSetDefault($context = null)
    {
        $defaultId = post('default');

        $alias = 'list';
        $listConfig = $this->config->validate($this->listConfig[$alias], $this->requiredConfig);

        $modelClass = $listConfig['model'];
        $model = new $modelClass;
        $query = $model->newQuery()->where($model->getKeyName(), $defaultId);
        $templateModel = $query->first();

        if (setting()->add('mail_template_id', $templateModel->getKey())) {
            flash()->set('success', lang('alert_set_default'));
        }

        return $this->refreshList($alias);
    }

    public function changes_onApplyChanges($context, $recordId = null)
    {
        $changes = post('changes');
        if (Mail_templates_data_model::updateChanges($recordId, $changes)) {
            flash()->set('success', sprintf(lang('alert_success'), 'Mail Template '.lang('text_updated')));
        }
        else {
            flash()->set('warning', sprintf(lang('alert_error_nothing'), lang('text_updated')));
        }

        return $this->redirect('mail_layouts/edit/'.$recordId);
    }

    public function formExtendFields($formWidget)
    {
        foreach ($formWidget->getFields() as $field) {
            switch ($formWidget->context) {
                case 'edit':
                case 'preview':
                    if (in_array($field->fieldName, ['original_id']))
                        $field->disabled = TRUE;
                    break;
            }
        }
    }

    public function formExtendQuery($query)
    {
        $query->with('templates');
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['name', 'lang:system::mail_templates.label_name', 'required|min:2|max:32'];
        $rules[] = ['language_id', 'lang:system::mail_templates.label_language', 'required|integer'];

        if ($form->context == 'create') {
            $rules[] = ['original_id', 'lang:system::mail_templates.label_clone', 'integer'];
        }
        else {
            $rules[] = ['layout', 'lang:system::mail_templates.label_layout', 'required'];
            $rules[] = ['plain_layout', 'lang:system::mail_templates.label_plain_layout', 'required'];
        }

        $rules[] = ['status', 'lang:admin::default.label_status', 'required|integer'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}