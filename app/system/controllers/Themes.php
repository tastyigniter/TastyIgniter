<?php namespace System\Controllers;

use Admin\Traits\WidgetMaker;
use AdminMenu;
use Exception;
use Main\Classes\ThemeManager;
use Request;
use System\Models\Themes_model;
use System\Traits\ConfigMaker;
use SystemException;
use Template;

class Themes extends \Admin\Classes\AdminController
{
    use WidgetMaker;
    use ConfigMaker;

    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Themes_model',
            'title' => 'lang:system::lang.themes.text_title',
            'emptyMessage' => 'lang:system::lang.themes.text_empty',
            'defaultSort' => ['date_added', 'DESC'],
            'configFile' => 'themes_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.themes.text_form_name',
        'model' => 'System\Models\Themes_model',
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'themes/edit/{code}',
            'redirectClose' => 'themes',
        ],
        'delete' => [
            'redirect' => 'themes',
        ],
        'configFile' => 'themes_model',
    ];

    /**
     * @var \Admin\Widgets\Form
     */
    public $formWidget;

    /**
     * @var \Admin\Widgets\Toolbar
     */
    public $toolbarWidget;

    protected $requiredPermissions = 'Site.Themes';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('themes', 'design');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Site.Themes.Manage'))
            Themes_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function edit($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::lang.themes.text_edit_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            Template::setButton(lang('system::lang.themes.button_source'), [
                'class' => 'btn btn-default',
                'href' => admin_url('themes/source/'.$themeCode),
            ]);

            $model = $this->formFindModelObject($themeCode);
            $this->initFormWidget($model, $context);
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function source($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::lang.themes.text_source_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            Template::setButton(lang('system::lang.themes.button_customize'), [
                'class' => 'btn btn-default',
                'href' => admin_url('themes/edit/'.$themeCode),
            ]);

            $model = $this->formFindModelObject($themeCode);
            $this->initFormWidget($model, $context);
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function upload($context)
    {
        $pageTitle = lang('system::lang.themes.text_add_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        Template::setButton(lang('system::lang.themes.button_browse'), ['class' => 'btn btn-default', 'href' => admin_url('updates/browse/themes')]);
    }

    public function delete($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::lang.themes.text_delete_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $themeManager = ThemeManager::instance();
            $themeClass = $themeManager->findTheme($themeCode);
            $model = Themes_model::whereCode($themeCode)->first();
            $activeThemeCode = params()->get('default_themes.main');

            // Theme must be disabled before it can be deleted
            if ($model AND $model->code == $activeThemeCode) {
                flash()->warning(sprintf(
                    lang('admin::lang.alert_error_nothing'),
                    lang('admin::lang.text_deleted').lang('system::lang.themes.text_theme_is_active')
                ));

                return $this->redirectBack();
            }

            // Theme not found in filesystem
            // so delete from database
            if (!$themeClass) {
                Themes_model::deleteTheme($themeCode, TRUE);
                flash()->success(sprintf(lang('admin::lang.alert_success'), "Theme deleted "));

                return $this->redirectBack();
            }

            // Lets display a delete confirmation screen
            // with list of files to be deleted
            $this->vars['themeModel'] = $model;
            $this->vars['themeClass'] = $themeClass;
            $this->vars['themeName'] = $themeClass->name;
            $this->vars['themeData'] = $model->data;
            $this->vars['filesToDelete'] = array_collapse($themeManager->listFiles($themeCode));
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onSetDefault()
    {
        if (!$this->getUser()->hasPermission('Site.Themes.Manage', TRUE))
            return $this->redirectBack();

        $themeName = post('code');
        if ($theme = Themes_model::activateTheme($themeName)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Theme ['.$theme->name.'] set as default '));
        }

        return $this->redirectBack();
    }

    public function edit_onSave($context, $themeCode = null)
    {
        $model = $this->formFindModelObject($themeCode);

        $this->initFormWidget($model, $context);

        if ($this->formValidate($model, $this->formWidget) === FALSE)
            return ['#notification' => $this->makePartial('flash')];

        $model->setAttribute('data', $this->formWidget->getSaveData());

        if ($model->save()) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Theme settings updated '));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), 'updated'));
        }

        return $this->refresh();
    }

    public function source_onSave($context, $themeCode = null)
    {
        $oldMTime = session('Theme.customize.mTime');

        $model = $this->formFindModelObject($themeCode);

        $this->initFormWidget($model, $context);

        $this->validateAfter(function ($validator) use ($oldMTime) {
            if (
                isset($this->formWidget->data->fileSource) AND
                $oldMTime != $this->formWidget->data->fileSource->mTime
            ) {
                $validator->errors()->add('markup', lang('system::lang.themes.alert_changes_confirm'));
            }
        });

        if ($this->formValidate($model, $this->formWidget) === FALSE)
            return ['#notification' => $this->makePartial('flash')];

        list($fileName, $attributes) = $this->getFileAttributes();

        if (ThemeManager::instance()->writeFile($fileName, $themeCode, $attributes)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Theme file ['.$fileName.'] updated '));
        }

        return $this->refresh();
    }

    public function source_onChooseFile($context, $themeCode = null)
    {
        $model = $this->formFindModelObject($themeCode);

        $this->initFormWidget($model, $context);

        session()->put('Theme.customize.file', post('Theme.customize.file'));

        return $this->refresh();
    }

    public function source_onManageSource($context, $themeCode = null)
    {
        $model = $this->formFindModelObject($themeCode);

        $this->initFormWidget($model, $context);

        $fileAction = post('action');
        $newFileName = post('name');

        $passed = $this->validatePasses(post(), [
            ['action', 'Source Action', 'required|in:rename,new'],
            ['name', 'Source Name', 'required|string'],
        ]);

        if ($passed === FALSE)
            return;

        $sourceField = $this->formWidget->getField('file');

        if ($fileAction == 'new') {
            ThemeManager::instance()->writeFile($newFileName, $themeCode);
        }
        else {
            $fileName = post($this->formWidget->arrayName.'[file]');
            ThemeManager::instance()->renameFile($fileName, $themeCode, $newFileName);
            $sourceField->value = $newFileName;
        }

        return [
            '#'.$sourceField->getId('group') => $this->formWidget->renderField($sourceField, [
                'useContainer' => FALSE,
            ]),
        ];
    }

    public function source_onDelete($context = null, $themeCode = null)
    {
        $model = $this->formFindModelObject($themeCode);

        $this->initFormWidget($model, $context);

        $fileName = post($this->formWidget->arrayName.'[file]');

        if (ThemeManager::instance()->deleteFile($fileName, $themeCode)) {
            session()->forget('Theme.customize');
            flash()->success(sprintf(lang('admin::lang.alert_success'), "Theme file [{$fileName}] deleted "));
        }
        else {
            flash()->danger(lang('admin::lang.alert_error_try_again'));
        }

        return $this->redirectBack();
    }

    public function upload_onUpload($context = null)
    {
        try {
            $themeManager = ThemeManager::instance();

            $this->validateUpload();

            $zipFile = Request::file('theme_zip');
            $themeManager->extractTheme($zipFile->path());

            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Theme uploaded '));

            return $this->redirect('themes');
        }
        catch (Exception $ex) {
            flash()->danger($ex->getMessage());

            return $this->refresh();
        }
    }

    public function delete_onDelete($context = null, $themeCode = null)
    {
        $theme = ThemeManager::instance()->findTheme($themeCode);
        $meta = $theme->config;

        if (Themes_model::deleteTheme($themeCode, post('delete_data') == 1)) {
            $name = $meta['name'] ?? '';

            flash()->success(sprintf(lang('admin::lang.alert_success'), "Theme {$name} deleted "));
        }
        else {
            flash()->danger(lang('admin::lang.alert_error_try_again'));
        }

        return $this->redirect('themes');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->type != 'button' OR $column->columnName != 'default')
            return null;

        $attributes = $column->attributes;

        $column->iconCssClass = 'fa fa-star-o';
        if ($record->themeClass AND $record->themeClass->isActive()) {
            $column->iconCssClass = 'fa fa-star';
            $attributes['title'] = 'lang:system::lang.themes.text_is_default';
            $attributes['data-request'] = null;
        }

        return $attributes;
    }

    public function initFormWidget($model, $context = null)
    {
        $configFile = $this->formConfig['configFile'];
        $config = $this->makeConfig($configFile, ['form']);
        $modelConfig = $config['form'] ?? [];

        $forgetSessionFile = TRUE;
        if ($context != 'source') {
            $modelConfig['tabs']['fields'] = $model->getFieldsConfig();
        }

        $arrayName = str_singular(strip_class_basename($model, '_model')).'[customize]';
        $modelConfig['model'] = $model;

        if ($context == 'source') {
            $file = session('Theme.customize.file');
            if ($file AND $mergeData = ThemeManager::instance()->readFile($file, $model->code)) {
                $forgetSessionFile = FALSE;
                $mergeData['file'] = $file;
            }
            else {
                $mergeData = [];
            }
        }
        else {
            $mergeData = $model->getFieldValues();
        }

        if ($forgetSessionFile)
            session()->forget('Theme.customize');

        $modelConfig['data'] = array_merge($mergeData, $model->toArray());
        $modelConfig['arrayName'] = $arrayName;
        $modelConfig['context'] = $context;

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $modelConfig);

        $this->formWidget->bindEvent('form.extendFieldsBefore', function () {
            $this->formExtendFieldsBefore($this->formWidget);
        });

        $this->formWidget->bindEvent('form.extendFields', function ($fields) {
            $this->formExtendFields($this->formWidget, $fields);
        });

        $this->formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar']) AND isset($this->widgets['toolbar'])) {
            $this->toolbarWidget = $this->widgets['toolbar'];
            $this->toolbarWidget->addButtons(array_get($modelConfig['toolbar'], 'buttons', []));
        }
    }

    public function formFindModelObject($recordId)
    {
        if (!strlen($recordId)) {
            throw new Exception(lang('admin::lang.form.missing_id'));
        }

        $model = $this->createModel();

        // Prepare query and find model record
        $query = $model->newQuery();
        $result = $query->where('code', $recordId)->first();

        if (!$result) {
            throw new Exception(sprintf(lang('admin::lang.form.not_found'), $recordId));
        }

        return $result;
    }

    public function formExtendFieldsBefore($form)
    {
        $file = session('Theme.customize.file');
        $parts = explode('/', $file);
        $dirName = $parts[0];

        if (strlen($file) AND in_array($dirName, ['_layouts', '_pages'])) {
            $form->fields['settings[components]']['context'] = ['source'];
            $form->tabs['fields']['codeSection']['context'] = ['source'];
        }
    }

    public function formExtendFields($form, $fields)
    {
        $markupField = $form->getField('markup');
        $fileField = $form->getField('file');
        if (!$markupField OR !$fileField)
            return;

        $file = $fileField->value;
        $themeCode = $form->model->code;
        $fileField->options = $this->prepareFilesList($themeCode, $file);

        $parts = explode('/', $file);
        $dirName = $parts[0];

        if (in_array($dirName, ['_layouts', '_pages'])) {
            if ($dirName == '_layouts') {
                $form->removeField('settings[title]');
                $form->removeField('settings[permalink]');
                $form->removeField('settings[layout]');
            }
        }
        else {
            $form->removeTab('lang:system::lang.themes.text_tab_meta');
        }

        if (!strlen($file)) {
            $form->removeTab('lang:system::lang.themes.text_tab_markup');

            return;
        }

        switch (pathinfo($file, PATHINFO_EXTENSION)) {
            case 'js':
                $markupField->config['mode'] = 'javascript';
                break;
            case 'css':
                $markupField->config['mode'] = 'css';
                break;
            case 'php':
            default:
                $markupField->config['mode'] = 'application/x-httpd-php';
                break;
        }

        session()->put('Theme.customize.mTime', isset($form->data->fileSource) ?
            $form->data->fileSource->mTime : null);
    }

    protected function createModel()
    {
        $class = $this->formConfig['model'];

        if (!isset($class) OR !strlen($class)) {
            throw new Exception(lang('admin::lang.form.missing_model'));
        }

        $model = new $class;

        return $model;
    }

    protected function validateUpload()
    {
        $zipFile = Request::file('theme_zip');
        if (!Request::hasFile('theme_zip') OR !$zipFile->isValid())
            throw new SystemException("Please upload a zip file");

        $name = $zipFile->getClientOriginalName();
        $theme = $zipFile->extension();

        if (preg_match('/\s/', $name))
            throw new SystemException(lang('system::lang.themes.error_upload_name'));

        if ($theme != 'zip')
            throw new SystemException(lang('system::lang.themes.error_upload_type'));

        if ($zipFile->getError())
            throw new SystemException(lang('system::lang.themes.error_php_upload').$zipFile->getErrorMessage());

        $name = substr($name, -strlen($theme));
        if (ThemeManager::instance()->hasTheme($name))
            throw new SystemException(lang('system::lang.themes.error_theme_exists'));

        return TRUE;
    }

    public function formValidate($model, $form)
    {
        $rules = [];
        if ($form->context != 'source') {
            foreach ($model->getFieldsConfig() as $name => $field) {
                if (!array_key_exists('rules', $field))
                    continue;

                $dottedName = implode('.', name_to_array($name));
                $rules[] = [$dottedName, $field['label'], $field['rules']];
            }
        }
        else {
            $rules = [
                ['file', 'Source File', 'required'],
                ['markup', 'lang:system::lang.themes.text_tab_markup', 'sometimes'],
                ['codeSection', 'lang:system::lang.themes.text_tab_php_section', 'sometimes'],
                ['settings.components.*.alias', 'lang:system::lang.themes.label_component_alias', 'sometimes|required|alpha'],
                ['settings.title', 'lang:system::lang.themes.label_title', 'sometimes|required|max:160'],
                ['settings.description', 'lang:system::lang.themes.label_description', 'sometimes|max:255'],
                ['settings.layout', 'lang:system::lang.themes.label_layout', 'sometimes|string'],
                ['settings.permalink', 'lang:system::lang.themes.label_permalink', 'sometimes|required|string'],
            ];
        }

        return $this->validatePasses(post($form->arrayName), $rules);
    }

    protected function prepareFilesList($themeCode, $currentFile = null)
    {
        return function () use ($themeCode, $currentFile) {
            $result = [];

            $themeManager = ThemeManager::instance();
            $list = $themeManager->listFiles($themeCode, ['_layouts', '_pages', '_partials']);
            foreach (array_sort($list) as $directory => $files) {
                foreach ($files as $file) {
                    $group = pathinfo($file, PATHINFO_DIRNAME);
                    $result[$file] = $group.'/'.pathinfo($file, PATHINFO_FILENAME);
                }
            }

            return $result;
        };
    }

    protected function getFileAttributes()
    {
        $fileData = post($this->formWidget->arrayName);
        $fileName = array_get($fileData, 'file');
        $code = array_get($fileData, 'codeSection');

        $code = preg_replace('/^\<\?php/', '', $code);
        $code = preg_replace('/^\<\?/', '', preg_replace('/\?>$/', '', $code));
        $code = trim($code, PHP_EOL);

        $attributes = [
            'code' => $code,
            'markup' => array_get($fileData, 'markup'),
            'data' => $this->parseComponents(array_get($fileData, 'settings')),
        ];

        return [$fileName, $attributes];
    }

    protected function parseComponents($settings)
    {
        $components = [];

        foreach (array_get($settings, 'components', []) as $component) {
            $alias = $component['alias'];
            if ($component['code'] != $component['alias'])
                $alias = $component['code'].' '.$component['alias'];

            $alias = sprintf('[%s]', $alias);
            $components[$alias] = $this->parseComponentPropertyValues(array_get($component, 'options', []));
        }

        $settings['components'] = $components;

        return $settings;
    }

    private function parseComponentPropertyValues($properties)
    {
        $properties = array_map(function (&$propertyValue) {
            if (is_numeric($propertyValue))
                $propertyValue += 0; // Convert to int or float

            return $propertyValue;
        }, $properties);

        return $properties;
    }
}