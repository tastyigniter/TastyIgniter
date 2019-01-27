<?php namespace System\Controllers;

use Admin\Traits\WidgetMaker;
use AdminMenu;
use Exception;
use Request;
use System\Classes\ExtensionManager;
use System\Models\Extensions_model;
use System\Models\Settings_model;
use SystemException;
use Template;

class Extensions extends \Admin\Classes\AdminController
{
    use WidgetMaker;

    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Extensions_model',
            'title' => 'lang:system::lang.extensions.text_title',
            'emptyMessage' => 'lang:system::lang.extensions.text_empty',
            'defaultSort' => ['title', 'ASC'],
            'showCheckboxes' => FALSE,
            'configFile' => 'extensions_model',
        ],
    ];

    protected $requiredPermissions = 'Admin.Extensions';

    /**
     * @var \Admin\Widgets\Form
     */
    public $formWidget;

    /**
     * @var \Admin\Widgets\Toolbar
     */
    public $toolbarWidget;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('extensions', 'system');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Admin.Extensions.Manage'))
            Extensions_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function edit($action, $vendor = null, $extension = null, $context = null)
    {
        try {
            if (!strlen($vendor) OR !strlen($extension)) {
                throw new SystemException(lang('system::lang.extensions.alert_setting_missing_id'));
            }

            $extensionCode = $vendor.'.'.$extension.'.'.$context;
            if (!$settingItem = Settings_model::make()->getSettingItem($extensionCode)) {
                throw new SystemException(lang('system::lang.extensions.alert_setting_not_found'));
            }

            if ($settingItem->permissions AND !$this->getUser()->hasPermission($settingItem->permissions, TRUE))
                return $this->redirectBack();

            $pageTitle = lang($settingItem->label ?: 'text_edit_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $model = $this->formFindModelObject($settingItem);

            $this->initFormWidget($model, $action);
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function upload($context = null)
    {
        Template::setTitle(lang('system::lang.extensions.text_add_title'));
        Template::setHeading(lang('system::lang.extensions.text_add_title'));

        Template::setButton(lang('system::lang.extensions.button_browse'), ['class' => 'btn btn-default', 'href' => admin_url('updates/browse/extensions')]);
    }

    public function delete($context, $extensionCode = null)
    {
        try {
            $pageTitle = lang('system::lang.extensions.text_delete_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $extensionManager = ExtensionManager::instance();
            $extensionClass = $extensionManager->findExtension($extensionCode);
            $model = Extensions_model::where('name', $extensionCode)->first();

            // Extension must be disabled before it can be deleted
            if ($model AND $model->status) {
                flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), lang('admin::lang.text_deleted').lang('system::lang.extensions.alert_is_installed')));

                return $this->redirectBack();
            }

            // Extension not found in filesystem
            // so delete from database
            if (!$extensionClass) {
                Extensions_model::deleteExtension($extensionCode);
                flash()->success(sprintf(lang('admin::lang.alert_success'), "Extension deleted "));

                return $this->redirectBack();
            }

            // Lets display a delete confirmation screen
            // with list of files to be deleted
            $meta = $extensionClass->extensionMeta();
            $this->vars['extensionModel'] = $model;
            $this->vars['extensionMeta'] = $meta;
            $this->vars['extensionName'] = $meta['name'] ?? '';
            $this->vars['extensionData'] = $this->extensionHasMigrations($extensionCode);
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onInstall($context = null)
    {
        $extensionCode = post('code');
        $extension = ExtensionManager::instance()->findExtension($extensionCode);

        if ($feedback = $this->checkDependencies($extension)) {
            flash()->error($feedback)->important();
        }
        else if (Extensions_model::install($extensionCode)) {
            $title = array_get($extension->extensionMeta(), 'name');
            flash()->success(sprintf(lang('admin::lang.alert_success'), "Extension {$title} installed "));
        }
        else {
            flash()->danger(lang('admin::lang.alert_error_try_again'));
        }

        return $this->refreshList('list');
    }

    public function index_onUninstall($context = null)
    {
        $extensionCode = post('code');
        $extension = ExtensionManager::instance()->findExtension($extensionCode);

        if (Extensions_model::uninstall($extensionCode) AND $extension) {
            $title = array_get($extension->extensionMeta(), 'name');

            flash()->success(sprintf(
                lang('admin::lang.alert_success'), "Extension {$title} uninstalled "
            ));
        }
        else {
            flash()->danger(lang('admin::lang.alert_error_try_again'));
        }

        return $this->refreshList('list');
    }

    public function edit_onSave($action, $vendor = null, $extension = null, $context = null)
    {
        if (!strlen($vendor) OR !strlen($extension)) {
            throw new SystemException(lang('system::lang.extensions.alert_setting_missing_id'));
        }

        $extensionCode = $vendor.'.'.$extension.'.'.$context;
        if (!$settingItem = Settings_model::make()->getSettingItem($extensionCode)) {
            throw new SystemException(lang('system::lang.extensions.alert_setting_not_found'));
        }

        if ($settingItem->permissions AND !$this->getUser()->hasPermission($settingItem->permissions, TRUE))
            return $this->redirectBack();

        $model = $this->formFindModelObject($settingItem);

        $this->initFormWidget($model, $action);

        if ($this->formValidate($model, $this->formWidget) === FALSE)
            return ['#notification' => $this->makePartial('flash')];

        $model->set($this->formWidget->getSaveData());
        if ($model->save()) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang($settingItem->label).' settings updated '));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), 'updated'));
        }

        if (post('close')) {
            return $this->redirect('settings');
        }

        return $this->refresh();
    }

    public function upload_onUpload($context = null)
    {
        try {
            $extensionManager = ExtensionManager::instance();

            $this->validateUpload();

            $zipFile = Request::file('extension_zip');
            $extensionManager->extractExtension($zipFile->path());

            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Extension uploaded '));

            return $this->redirect('extensions');
        }
        catch (Exception $ex) {
            flash()->danger($ex->getMessage());

            return $this->refresh();
        }
    }

    public function delete_onDelete($context = null, $extensionCode = null)
    {
        $extension = ExtensionManager::instance()->findExtension($extensionCode);
        $title = array_get($extension->extensionMeta(), 'name');

        if (Extensions_model::deleteExtension($extensionCode, post('delete_data') == 1)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), "Extension {$title} deleted "));
        }
        else {
            flash()->danger(lang('admin::lang.alert_error_try_again'));
        }

        return $this->redirect('extensions');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->type != 'button')
            return null;

        $attributes = $column->attributes;

        if ($column->columnName == 'delete' AND $record->status)
            $attributes['class'] = $attributes['class'].' disabled';

        if ($column->columnName != 'delete' AND !$record->class)
            $attributes['class'] = 'btn btn-default disabled';

        return $attributes;
    }

    protected function initFormWidget($model, $context = null)
    {
        $config = $model->getFieldConfig();

        $modelConfig = array_except($config, 'toolbar');
        $modelConfig['model'] = $model;
        $modelConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $modelConfig['context'] = $context;

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $modelConfig);
        $this->formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($config['toolbar']) AND isset($this->widgets['toolbar'])) {
            $this->toolbarWidget = $this->widgets['toolbar'];
            $this->toolbarWidget->addButtons(array_get($config['toolbar'], 'buttons', []));
        }
    }

    protected function createModel($class)
    {
        if (!strlen($class))
            throw new SystemException(lang('system::lang.extensions.alert_setting_model_missing'));

        if (!class_exists($class))
            throw new SystemException(sprintf(lang('system::lang.extensions.alert_setting_model_not_found'), $class));

        $model = new $class;

        return $model;
    }

    protected function formFindModelObject($settingItem)
    {
        $model = $this->createModel($settingItem->model);

        // Prepare query and find model record
        $result = $model->getSettingsRecord();

        if (!$result) {
            return $model;
        }

        return $result;
    }

    protected function formValidate($model, $form)
    {
        $rules = [];
        if (isset($form->config['rules']))
            $rules = $form->config['rules'];

        if ($modelRules = $model->validateRules($form))
            $rules = $modelRules;

        return $this->validatePasses($form->getSaveData(), $rules);
    }

    protected function validateUpload()
    {
        $zipFile = Request::file('extension_zip');
        if (!Request::hasFile('extension_zip') OR !$zipFile->isValid())
            throw new SystemException("Please upload a zip file");

        $name = $zipFile->getClientOriginalName();
        $extension = $zipFile->extension();

        if (preg_match('/\s/', $name))
            throw new SystemException(lang('system::lang.extensions.error_upload_name'));

        if ($extension != 'zip')
            throw new SystemException(lang('system::lang.extensions.error_upload_type'));

        if ($zipFile->getError())
            throw new SystemException(lang('system::lang.extensions.error_php_upload').$zipFile->getErrorMessage());

        $name = substr($name, -strlen($extension));
        if (ExtensionManager::instance()->hasExtension($name))
            throw new SystemException(lang('system::lang.extensions.error_extension_exists'));

        return TRUE;
    }

    protected function checkDependencies($extension)
    {
        $feedback = null;
        $extensionManager = ExtensionManager::instance();
        $required = $extensionManager->getDependencies($extension) ?: [];
        foreach ($required as $require) {
            $requireExtension = $extensionManager->findExtension($require);
            if (!$requireExtension)
                $feedback .= "Required extension [{$require}] was not found.\n";

            if ($extensionManager->isDisabled($require))
                $feedback .= "Required extension [{$require}] must be enabled to proceed.\n";
        }

        return $feedback;
    }

    protected function extensionHasMigrations($extension)
    {
        try {
            $extensionManager = ExtensionManager::instance();

            return count($extensionManager->files($extension, 'database/migrations')) > 0;
        }
        catch (Exception $ex) {
            return FALSE;
        }
    }
}