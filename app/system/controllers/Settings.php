<?php namespace System\Controllers;

use Admin\Models\Locations_model;
use Admin\Traits\WidgetMaker;
use AdminMenu;
use Exception;
use System\Models\Currencies_model;
use System\Models\Settings_model;
use Template;

class Settings extends \Admin\Classes\AdminController
{
    use WidgetMaker;

    protected $requiredPermissions = 'Site.Settings';

    protected $modelClass = 'System\Models\Settings_model';

    protected $modelConfig;

    public $formWidget;

    public $toolbarWidget;

    public $settingCode;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index()
    {
        $pageTitle = lang('system::settings.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);
        $this->vars['settings'] = $this->createModel()->listSettingItems();
    }

    public function edit($context, $settingCode = null)
    {
        try {
            $this->settingCode = $settingCode;
            list($model, $definition) = $this->findSettingDefinitions($settingCode);
            if (!$definition) {
                throw new Exception(lang('system::settings.alert_settings_not_found'));
            }

            $pageTitle = sprintf(lang('system::settings.text_edit_title'), lang($definition['label']));
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $this->initWidgets($model, $definition);
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function edit_onSave($context, $settingCode = null)
    {
        list($model, $definition) = $this->findSettingDefinitions($settingCode);
        if (!$definition) {
            throw new Exception(lang('system::settings.alert_settings_not_found'));
        }

        $this->initWidgets($model, $definition);

        $validate = $this->formValidate($this->formWidget);
        if ($validate === FALSE)
            return;

        $updated = Settings_model::updateSettings('config', $this->formWidget->getSaveData());

        if (is_numeric(post('default_location_id'))) {
            $this->config->set_item('default_location_id', post('default_location_id'));
            Locations_model::updateDefault();
        }

        if (post('accepted_currencies')) {
            Currencies_model::updateAcceptedCurrencies(post('accepted_currencies'));
        }

        if ($updated) {
            flash()->success(sprintf(lang('system::settings.alert_success'), lang($definition['label']).' settings updated '));
        }
        else {
            flash()->warning(sprintf(lang('system::settings.alert_error_nothing'), 'updated'));
        }

        return $this->refresh();
    }

    public function edit_onSendTest()
    {
        $json = [];

        if (!post('send_test_email')) {
            $json['error'] = lang('admin::default.alert_error_try_again');
        }

        if (empty($json)) {
            $this->load->library('email');                                                        //loading upload library
            $this->email->initialize();

            $this->email->from(strtolower($this->config->item('site_email')), $this->config->item('site_name'));
            $this->email->to(strtolower($this->config->item('site_email')));
            $this->email->subject('This a test email');
            $this->email->message('This is a test email. If you\'ve received this, it means emails are working in TastyIgniter.');

            if ($this->email->send()) {
                $json['success'] = sprintf(lang('system::settings.alert_email_sent'), $this->config->item('site_email'));
            }
            else {
                $json['error'] = $this->email->print_debugger(['headers']);
            }
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_output(json_encode($json));                                            // encode the json array and set final out to be sent to jQuery AJAX
        }
        else {
            if (isset($json['error'])) flash()->danger($json['error']);
            if (isset($json['success'])) flash()->success($json['success']);

            return $this->redirect('settings/#mail');
        }
    }

    public function initWidgets($model, $definition)
    {
        $this->modelConfig = $model->getFieldConfig();

        $formConfig = array_get($definition, 'form', []);
        $formConfig['model'] = $model;
        $formConfig['data'] = $model->getFieldValues();
        $formConfig['alias'] = 'form-'.$this->settingCode;
        $formConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $formConfig['context'] = 'edit';

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $this->formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($this->modelConfig['toolbar']) AND isset($this->widgets['toolbar'])) {
            $this->toolbarWidget = $this->widgets['toolbar'];
            $this->toolbarWidget->addButtons(array_get($this->modelConfig['toolbar'], 'buttons', []));
        }
    }

    protected function findSettingDefinitions($code)
    {
        if (!strlen($code))
            throw new Exception(lang('system::settings.text_form_missing_id'));

        // Prep the list widget config
        $model = $this->createModel();

        $definition = $model->getSettingDefinitions($code);

        return [$model, $definition];
    }

    protected function createModel()
    {
        if (!isset($this->modelClass) OR !strlen($this->modelClass)) {
            throw new Exception(lang('system::settings.alert_settings_missing_model'));
        }

        return new $this->modelClass();
    }

    protected function formValidate($form)
    {
        if (!isset($form->config['rules']))
            return null;

        return $this->validatePasses($form->getSaveData(), $form->config['rules']);
    }
}