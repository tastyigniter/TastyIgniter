<?php namespace System\Controllers;

use Admin\Traits\FormExtendable;
use Admin\Traits\WidgetMaker;
use AdminAuth;
use AdminMenu;
use Exception;
use File;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Mail;
use Request;
use Session;
use Template;

class Settings extends \Admin\Classes\AdminController
{
    use WidgetMaker;
    use FormExtendable;

    protected $requiredPermissions = 'Site.Settings';

    protected $modelClass = 'System\Models\Settings_model';

    /**
     * @var \Admin\Widgets\Form
     */
    public $formWidget;

    /**
     * @var \Admin\Widgets\Toolbar
     */
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
        if ($settingCode == 'setup') {
            $this->addJs('~/app/admin/formwidgets/repeater/assets/js/jquery-sortable.js', 'jquery-sortable-js');
            $this->addJs('~/app/admin/assets/js/ratings.js', 'ratings-js');
        }

        try {
            $this->settingCode = $settingCode;
            [$model, $definition] = $this->findSettingDefinitions($settingCode);
            if (!$definition) {
                throw new Exception(lang('system::lang.settings.alert_settings_not_found'));
            }

            if ($definition->permission AND !AdminAuth::user()->hasPermission($definition->permission))
                return Response::make(View::make('admin::access_denied'), 403);

            $pageTitle = sprintf(lang('system::lang.settings.text_edit_title'), lang($definition->label));
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
        [$model, $definition] = $this->findSettingDefinitions($settingCode);
        if (!$definition) {
            throw new Exception(lang('system::lang.settings.alert_settings_not_found'));
        }

        if ($definition->permission AND !AdminAuth::user()->hasPermission($definition->permission))
            return Response::make(View::make('admin::access_denied'), 403);

        $this->initWidgets($model, $definition);

        if ($this->formValidate($this->formWidget) === FALSE)
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : FALSE;

        $this->formBeforeSave($model);

        setting()->set($this->formWidget->getSaveData());
        setting()->save();

        $this->formAfterSave($model);

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($definition->label).' settings updated '));

        if (post('close')) {
            return $this->redirect('settings');
        }

        return $this->refresh();
    }

    public function edit_onTestMail()
    {
        [$model, $definition] = $this->findSettingDefinitions('mail');
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
        $modelConfig = $model->getFieldConfig($definition->code);

        $formConfig = array_except($modelConfig, 'toolbar');
        $formConfig['model'] = $model;
        $formConfig['data'] = array_undot($model->getFieldValues());
        $formConfig['alias'] = 'form-'.$this->settingCode;
        $formConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $formConfig['context'] = 'edit';

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $this->formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar']) AND isset($this->widgets['toolbar'])) {
            $this->toolbarWidget = $this->widgets['toolbar'];
            $this->toolbarWidget->reInitialize($modelConfig['toolbar']);
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

    protected function formAfterSave($model)
    {
        $this->validateSettingItems(TRUE);
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
            $settingItems = array_get($model->listSettingItems(), 'core');
            $settingValues = array_undot($model->getFieldValues());

            foreach ($settingItems as $settingItem) {
                $settingItemForm = $this->createModel()->getFieldConfig($settingItem->code);

                if (!isset($settingItemForm['rules']))
                    continue;

                $validator = $this->makeValidator($settingValues, $settingItemForm['rules']);
                $errors = $validator->fails() ? $validator->errors() : [];

                $settingItemErrors[$settingItem->code] = $errors;
            }

            Session::put('settings.errors', $settingItemErrors);
        }

        return $this->settingItemErrors = $settingItemErrors;
    }
}