<?php namespace System\Controllers;

use Admin\Traits\WidgetMaker;
use AdminMenu;
use Event;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Main\Classes\ThemeManager;
use Request;
use System\Facades\Assets;
use System\Libraries\Assets as AssetsManager;
use System\Models\Themes_model;
use System\Traits\ConfigMaker;
use System\Traits\SessionMaker;
use Template;

class Themes extends \Admin\Classes\AdminController
{
    use WidgetMaker;
    use ConfigMaker;
    use SessionMaker;

    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Themes_model',
            'title' => 'lang:system::lang.themes.text_title',
            'emptyMessage' => 'lang:system::lang.themes.text_empty',
            'defaultSort' => ['theme_id', 'DESC'],
            'configFile' => 'themes_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.themes.text_form_name',
        'model' => 'System\Models\Themes_model',
        'request' => 'System\Requests\Theme',
        'edit' => [
            'title' => 'system::lang.themes.text_edit_title',
            'redirect' => 'themes/edit/{code}',
            'redirectClose' => 'themes',
        ],
        'source' => [
            'title' => 'system::lang.themes.text_source_title',
            'redirect' => 'themes/source/{code}',
            'redirectClose' => 'themes',
        ],
        'delete' => [
            'redirect' => 'themes',
        ],
        'configFile' => 'themes_model',
    ];

    protected $templateConfig = [
        '_pages' => '~/app/main/template/config/page',
        '_partials' => '~/app/main/template/config/partial',
        '_layouts' => '~/app/main/template/config/layout',
        '_content' => '~/app/main/template/config/content',
    ];

    protected $requiredPermissions = 'Site.Themes';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('themes', 'design');
    }

    public function index()
    {
        Themes_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function edit($context, $themeCode = null)
    {
        Template::setButton(lang('system::lang.themes.button_source'), [
            'class' => 'btn btn-default',
            'href' => admin_url('themes/source/'.$themeCode),
        ]);

        $this->asExtension('FormController')->edit($context, $themeCode);
    }

    public function source($context, $themeCode = null)
    {
        Template::setButton(lang('system::lang.themes.button_customize'), [
            'class' => 'btn btn-default',
            'href' => admin_url('themes/edit/'.$themeCode),
        ]);

        if (!ThemeManager::instance()->findParent($themeCode)) {
            Template::setButton(lang('system::lang.themes.button_child'), [
                'class' => 'btn btn-default pull-right',
                'data-request' => 'onCreateChild',
            ]);
        }

        $this->asExtension('FormController')->edit($context, $themeCode);
    }

    public function delete($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::lang.themes.text_delete_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $themeManager = ThemeManager::instance();
            $theme = $themeManager->findTheme($themeCode);
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
            if (!$theme) {
                Themes_model::deleteTheme($themeCode, TRUE);
                flash()->success(sprintf(lang('admin::lang.alert_success'), "Theme deleted "));

                return $this->redirectBack();
            }

            // Lets display a delete confirmation screen
            // with list of files to be deleted
            $this->vars['themeModel'] = $model;
            $this->vars['themeObj'] = $theme;
            $this->vars['themeData'] = $model->data;
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onSetDefault()
    {
        $themeName = post('code');
        if ($theme = Themes_model::activateTheme($themeName)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Theme ['.$theme->name.'] set as default '));
        }

        return $this->redirectBack();
    }

    public function source_onSave($context, $themeCode = null)
    {
        if (ThemeManager::instance()->isLocked($themeCode)) {
            flash()->danger(lang('system::lang.themes.alert_theme_locked'))->important();

            return;
        }

        $formController = $this->asExtension('FormController');
        $model = $this->formFindModelObject($themeCode);
        $formController->initForm($model, $context);

        [$fileName, $attributes] = $this->getTemplateAttributes();
        ThemeManager::instance()->writeFile($fileName, $attributes, $model->code);

        flash()->success(
            sprintf(lang('admin::lang.form.edit_success'), lang('lang:system::lang.themes.text_form_name'))
        );

        if ($redirect = $formController->makeRedirect($context, $model)) {
            return $redirect;
        }
    }

    public function source_onChooseFile($context, $themeCode = null)
    {
        $model = $this->formFindModelObject($themeCode);

        $this->asExtension('FormController')->initForm($model, $context);

        $this->validate(post('Theme.source.template'), [
            ['type', 'Source Type', 'required|in:_pages,_partials,_layouts,_content'],
            ['file', 'Source File', 'sometimes|present|string'],
        ]);

        $this->setTemplateValue('type', post('Theme.source.template.type'));
        $this->setTemplateValue('file', post('Theme.source.template.file'));

        return $this->refresh();
    }

    public function source_onManageSource($context, $themeCode = null)
    {
        if (ThemeManager::instance()->isLocked($themeCode)) {
            flash()->danger(lang('system::lang.themes.alert_theme_locked'))->important();

            return;
        }

        $model = $this->formFindModelObject($themeCode);

        $this->asExtension('FormController')->initForm($model, $context);

        $this->validate(post(), [
            ['action', 'Source Action', 'required|in:delete,rename,new'],
            ['name', 'Source Name', 'present|regex:/^[a-zA-Z-_\/]+$/'],
            ['Theme.source.template.type', 'Source Type', 'required|in:_pages,_partials,_layouts,_content'],
            ['Theme.source.template.file', 'Source File', 'required_unless:action,new|regex:/^[a-zA-Z-_\/]+$/'],
        ]);

        $fileAction = post('action');
        $newFileName = sprintf('%s/%s', post('Theme.source.template.type'), post('name'));
        $fileName = implode('/', post('Theme.source.template'));
        $manager = ThemeManager::instance();

        if ($fileAction == 'rename') {
            $manager->renameFile($fileName, $newFileName, $themeCode);
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Template file renamed '));
        }
        elseif ($fileAction == 'delete') {
            $manager->deleteFile($fileName, $themeCode);
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Template file deleted '));
        }
        else {
            $manager->newFile($newFileName, $themeCode);
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Template file created '));
        }

        $this->setTemplateValue('type', post('Theme.source.template.type'));
        $this->setTemplateValue('file', post('name'));

        return $this->refresh();
    }

    public function source_onCreateChild($context, $themeCode = null)
    {
        $manager = ThemeManager::instance();

        $model = $this->formFindModelObject($themeCode);

        $childTheme = $manager->createChildTheme($model);

        $manager->loadThemes();
        Themes_model::syncAll();
        Themes_model::activateTheme($childTheme->code);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Child theme ['.$childTheme->name.'] created '));

        return $this->redirect('themes/source/'.$childTheme->code);
    }

    public function delete_onDelete($context = null, $themeCode = null)
    {
        if (Themes_model::deleteTheme($themeCode, post('delete_data', 1) == 1)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), "Theme deleted "));
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
        if ($record->getTheme() AND $record->getTheme()->isActive()) {
            $column->iconCssClass = 'fa fa-star';
            $attributes['title'] = 'lang:system::lang.themes.text_is_default';
            $attributes['data-request'] = null;
        }

        return $attributes;
    }

    public function formExtendConfig(&$formConfig)
    {
        $formConfig['data'] = $formConfig['model']->toArray();

        if ($formConfig['context'] != 'source') {
            $formConfig['tabs']['fields'] = $formConfig['model']->getFieldsConfig();
            $formConfig['data'] = array_merge($formConfig['model']->getFieldValues(), $formConfig['data']);
            $formConfig['arrayName'] .= '[data]';

            return;
        }

        $formConfig['arrayName'] .= '[source]';
        $formConfig['tabs']['cssClass'] = 'theme-source-editor';

        $type = $this->getTemplateValue('type');
        $file = $this->getTemplateValue('file');
        $formConfig['fields']['template']['default']['type'] = $type;

        if (!empty($file))
            $this->mergeTemplateConfigIntoFormConfig($formConfig, $type, $file);

        if (Request::method() === 'GET')
            $this->setTemplateValue('mTime', optional($formConfig['data']['fileSource'] ?? [])->mTime);
    }

    public function formFindModelObject($recordId)
    {
        if (!strlen($recordId)) {
            throw new Exception(lang('admin::lang.form.missing_id'));
        }

        $model = $this->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();
        $result = $query->where('code', $recordId)->first();

        if (!$result) {
            throw new Exception(sprintf(lang('admin::lang.form.not_found'), $recordId));
        }

        return $result;
    }

    public function formAfterSave($model)
    {
        if ($this->widgets['form']->context != 'source') {
            $this->buildAssetsBundle($model);
        }
    }

    public function wasTemplateModified()
    {
        return $this->getTemplateValue('mTime') != optional($this->widgets['form']->data->fileSource)->mTime;
    }

    protected function getTemplateAttributes()
    {
        $formData = $this->widgets['form']->getSaveData();
        $fileName = implode('/', array_get($formData, 'template', []));

        $code = array_get($formData, 'codeSection');
        $code = preg_replace('/^\<\?php/', '', $code);
        $code = preg_replace('/^\<\?/', '', preg_replace('/\?>$/', '', $code));

        $result['code'] = trim($code, PHP_EOL);
        $result['markup'] = array_get($formData, 'markup');
        $result['settings'] = array_except(array_get($formData, 'settings', []), 'components');

        return [$fileName, $result];
    }

    protected function buildAssetsBundle($model)
    {
        if (!$model->getFieldsConfig())
            return;

        $loaded = FALSE;
        $theme = $model->getTheme();
        $file = '/_meta/assets.json';

        if (File::exists($path = $theme->path.$file)) {
            Assets::addFromManifest($theme->publicPath.$file);
            $loaded = TRUE;
        }

        if ($theme->hasParent() AND File::exists($path = $theme->getParent()->path.$file)) {
            Assets::addFromManifest($theme->getParent()->publicPath.$file);
            $loaded = TRUE;
        }

        if (!$loaded)
            return;

        Event::listen('assets.combiner.beforePrepare', function (AssetsManager $combiner, $assets) {
            ThemeManager::applyAssetVariablesOnCombinerFilters(
                array_flatten($combiner->getFilters())
            );
        });

        try {
            $output = '';
            Artisan::call('igniter:util', ['name' => 'compile scss']);
            $output .= Artisan::output();

            Artisan::call('igniter:util', ['name' => 'compile js']);
            $output .= Artisan::output();

            Log::info($output);
        }
        catch (Exception $ex) {
            Log::error($ex);
            flash()->error('Building assets bundle error: '.$ex->getMessage())->important();
        }
    }

    public function getTemplateValue($name, $default = null)
    {
        $themeCode = $this->params[0] ?? 'default';
        $cacheKey = $themeCode.'-selected-'.$name;

        return $this->getSession($cacheKey, $default);
    }

    public function setTemplateValue($name, $value)
    {
        $themeCode = $this->params[0] ?? 'default';
        $cacheKey = $themeCode.'-selected-'.$name;
        $this->putSession($cacheKey, $value);
    }

    /**
     * @param $formConfig
     * @param $type
     * @param $file
     */
    protected function mergeTemplateConfigIntoFormConfig(&$formConfig, $type, $file)
    {
        try {
            $template = ThemeManager::instance()->readFile($type.'/'.$file, $formConfig['model']->code);

            $configFile = $this->templateConfig[$type];
            $templateConfig = $this->loadConfig($configFile, ['form'], 'form');
            $formConfig['fields'] = array_merge($formConfig['fields'], $templateConfig['fields'] ?? []);
            $formConfig['tabs']['fields'] = array_merge($formConfig['tabs']['fields'], $templateConfig['tabs']['fields'] ?? []);
            $formConfig['fields']['template']['default']['file'] = $file;

            $formConfig['data'] = array_merge([
                'fileName' => $template->getFileName(),
                'baseFileName' => $template->getBaseFileName(),
                'settings' => $template->settings,
                'markup' => $template->getMarkup(),
                'codeSection' => $template->getCode(),
                'fileSource' => $template,
            ], $formConfig['data']);
        }
        catch (ApplicationException $e) {
        }
    }
}