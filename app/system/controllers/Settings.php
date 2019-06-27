<?php namespace System\Controllers;

use Admin\Models\Locations_model;
use Admin\Traits\WidgetMaker;
use AdminAuth;
use AdminMenu;
use Exception;
use File;
use Illuminate\Mail\Message;
use Mail;
use Request;
use Session;
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

    public $settingItemErrors = [];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index()
    {
        $this->validateSettingItems(TRUE);

        // For security reasons, delete setup files if still exists.
        if (File::isFile(base_path('setup.php')) OR File::isDirectory(base_path('setup'))) {
            flash()->danger(lang('system::lang.settings.alert_delete_setup_files'))->important()->now();
        }

        $pageTitle = lang('system::lang.settings.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);
        $this->vars['settings'] = $this->createModel()->listSettingItems();
        $this->vars['settingItemErrors'] = $this->settingItemErrors;
    }

    public function edit($context, $settingCode = null)
    {
        try {
            $this->settingCode = $settingCode;
            list($model, $definition) = $this->findSettingDefinitions($settingCode);
            if (!$definition) {
                throw new Exception(lang('system::lang.settings.alert_settings_not_found'));
            }

            $pageTitle = sprintf(lang('system::lang.settings.text_edit_title'), lang($definition['label']));
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $this->initWidgets($model, $definition);

            $this->validateSettingItems();
            if ($errors = array_get($this->settingItemErrors, $settingCode))
                Session::flash('errors', $errors);
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function edit_onSave($context, $settingCode = null)
    {
        list($model, $definition) = $this->findSettingDefinitions($settingCode);
        if (!$definition) {
            throw new Exception(lang('system::lang.settings.alert_settings_not_found'));
        }

        $this->initWidgets($model, $definition);

        if ($this->formValidate($this->formWidget) === FALSE)
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : FALSE;

        if (is_numeric($locationId = post('default_location_id'))) {
            Locations_model::updateDefault(['location_id' => $locationId]);
        }

        setting()->set($this->formWidget->getSaveData());
        setting()->save();

        $this->validateSettingItems(TRUE);

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($definition['label']).' settings updated '));

        if (post('close')) {
            return $this->redirect('settings');
        }

        return $this->refresh();
    }

    public function edit_onTestMail()
    {
        list($model, $definition) = $this->findSettingDefinitions('mail');
        if (!$definition) {
            throw new Exception(lang('system::lang.settings.alert_settings_not_found'));
        }

        $this->initWidgets($model, $definition);

        if ($this->formValidate($this->formWidget) === FALSE)
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : FALSE;

        setting()->set($this->formWidget->getSaveData());

        $name = AdminAuth::getStaffName();
        $email = AdminAuth::getStaffEmail();
        $text = 'This is a test email. If you\'ve received this, it means emails are working in TastyIgniter.';

        try {
            Mail::raw($text, function (Message $message) use ($name, $email) {
                $message->to($email, $name)->subject('This a test email');
            });

            flash()->success(sprintf(lang('system::lang.settings.alert_email_sent'), $email));
        }
        catch (Exception $ex) {
            flash()->error($ex->getMessage());
        }

        return $this->refresh();
    }

    public function initWidgets($model, $definition)
    {
        $this->modelConfig = $model->getFieldConfig();

        $formConfig = array_get($definition, 'form', []);
        $formConfig['model'] = $model;
        $formConfig['data'] = array_undot($model->getFieldValues());
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
            throw new Exception(lang('admin::lang.form.missing_id'));

        // Prep the list widget config
        $model = $this->createModel();

        $definition = $model->getSettingDefinitions($code);

        return [$model, $definition];
    }

    protected function createModel()
    {
        if (!isset($this->modelClass) OR !strlen($this->modelClass)) {
            throw new Exception(lang('system::lang.settings.alert_settings_missing_model'));
        }

        return new $this->modelClass();
    }

    protected function formValidate($form)
    {
        if (!isset($form->config['rules']))
            return null;

        return $this->validatePasses($form->getSaveData(), $form->config['rules']);
    }

    protected function validateSettingItems($skipSession = FALSE)
    {
        $settingItemErrors = Session::get('settings.errors', []);

        if ($skipSession OR !$settingItemErrors) {
            $model = $this->createModel();
            $settingGroup = $model->listSettingItems();
            $settingValues = array_undot($model->getFieldValues());

            foreach (array_get($settingGroup, 'core') as $listSettingItem) {
                if (!isset($listSettingItem->form['rules']))
                    continue;

                $validator = $this->makeValidator($settingValues, $listSettingItem->form['rules']);
                $errors = $validator->fails() ? $validator->errors() : [];

                $settingItemErrors[$listSettingItem->code] = $errors;
            }

            Session::put('settings.errors', $settingItemErrors);
        }

        return $this->settingItemErrors = $settingItemErrors;
    }
}