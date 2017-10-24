<?php namespace System\Controllers;

use Admin\Traits\WidgetMaker;
use Assets;
use Exception;
use Main\Classes\ThemeManager;
use System\Traits\ConfigMaker;
use Template;
use AdminMenu;

class Themes extends \Admin\Classes\AdminController
{
    use WidgetMaker;
    use ConfigMaker;

    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Themes_model',
            'title'        => 'lang:system::themes.text_title',
            'emptyMessage' => 'lang:system::themes.text_empty',
            'defaultSort'  => ['date_added', 'DESC'],
            'configFile'   => 'themes_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::themes.text_form_name',
        'model'      => 'System\Models\Themes_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'themes/edit/{code}',
            'redirectClose' => 'themes',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'themes/edit/{code}',
            'redirectClose' => 'themes',
        ],
        'delete'     => [
            'redirect' => 'themes',
        ],
        'configFile' => 'themes_model',
    ];

    public $formWidget;

    public $toolbarWidget;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('themes', 'design');
    }

    public function edit($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::themes.text_edit_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            Template::setButton(lang('system::themes.button_source'), [
                'class' => 'btn btn-default',
                'href'  => admin_url('themes/source/'.$themeCode),
            ]);

            $model = $this->formFindModelObject($themeCode);
            $this->initFormWidget($model, $context);
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function source($context, $themeCode = null)
    {
        Assets::addCss(assets_url('js/codemirror/material.css'), 'material-css');
        Assets::addCss(assets_url('js/codemirror/codemirror.css'), 'codemirror-css');
        Assets::addJs(assets_url('js/codemirror/codemirror.js'), 'codemirror-js');
        Assets::addJs(assets_url('js/codemirror/xml/xml.js'), 'codemirror-xml-js');
        Assets::addJs(assets_url('js/codemirror/css/css.js'), 'codemirror-css-js');
        Assets::addJs(assets_url('js/codemirror/javascript/javascript.js'), 'codemirror-javascript-js');
        Assets::addJs(assets_url('js/codemirror/php/php.js'), 'codemirror-php-js');
        Assets::addJs(assets_url('js/codemirror/htmlmixed/htmlmixed.js'), 'codemirror-htmlmixed-js');
        Assets::addJs(assets_url('js/codemirror/clike/clike.js'), 'codemirror-clike-js');

        try {
            $pageTitle = lang('system::themes.text_edit_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $model = $this->formFindModelObject($themeCode);
            $this->initFormWidget($model, $context);
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function copy($context, $themeCode = null)
    {
        try {
            $pageTitle = lang('system::themes.text_copy_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $themeManager = ThemeManager::instance();

            $model = $this->formFindModelObject($themeCode);
            $this->vars['themeModel'] = $model;
            $this->vars['themeName'] = $model->name;
            $this->vars['themeData'] = $model->data;
            $this->vars['filesToCopy'] = $themeManager->getFilesToCopy($model->code);
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function upload($context)
    {
        try {
            $pageTitle = lang('system::themes.text_edit_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $model = $this->createModel();
//            $this->initFormWidget($model, $context);
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onDelete()
    {
        dd(post());
    }

    public function index_onSetDefault()
    {
        dd(post());
    }

    public function copy_onCreateChild()
    {
        dd(post());
    }

    public function listExtendQuery($query)
    {
        $query->isCustomisable();
    }

    public function initFormWidget($model, $context = null)
    {
        $configFile = $this->formConfig['configFile'];
        $config = $this->makeConfig($configFile, ['form']);
        $modelConfig = isset($config['form']) ? $config['form'] : [];

        if ($context != 'source') {
            $modelConfig['tabs']['fields'] = $model->getFieldsConfig();
        }

        $modelConfig['model'] = $model;
        $modelConfig['data'] = array_merge($model->getFieldValues(), $model->toArray());
        $modelConfig['arrayName'] = str_singular(strip_class_basename($model, '_model')).'[customize]';
        $modelConfig['context'] = $context;

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $modelConfig);
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
            throw new Exception(lang('system::default.form.missing_id'));
        }

        $model = $this->createModel();

        // Prepare query and find model record
        $query = $model->newQuery();
//        $this->controller->formExtendQuery($query);
        $result = $query->isCustomisable()->where('code', $recordId)->first();

        if (!$result) {
            throw new Exception(lang('system::default.form.not_found'));
        }

        return $result;
    }

    protected function createModel()
    {
        $class = $this->formConfig['model'];

        if (!isset($class) OR !strlen($class)) {
            throw new Exception(lang('system::themes.alert_themes_missing_model'));
        }

        $model = new $class;

        return $model;
    }

    protected function _addTheme()
    {
        if (isset($_FILES['theme_zip'])) {
            AdminAuth::restrict('Site.Themes.Add', admin_url('themes/add'));

            if ($this->validateUpload() === TRUE) {
                $extractedPath = ThemeManager::instance()->extractTheme($_FILES['theme_zip']['tmp_name']);
                $theme_code = basename($extractedPath);

                if (file_exists($extractedPath) AND ThemeManager::instance()->loadTheme($theme_code, $extractedPath)) {
                    $theme_meta = ThemeManager::instance()->themeMeta($theme_code);

                    if (is_array($theme_meta)) {
                        $update['name'] = $theme_meta['code'];
                        $update['title'] = $theme_meta['name'];
                        $update['version'] = $theme_meta['version'];
                        $update['status'] = 1;
                        $this->Themes_model->updateTheme($update);
                    }

                    $theme_name = isset($theme_meta['name']) ? $theme_meta['name'] : $theme_code;

                    log_activity(AdminAuth::getStaffId(), 'added', 'themes',
                        get_activity_message('activity_custom_no_link',
                            ['{staff}', '{action}', '{context}', '{item}'],
                            [AdminAuth::getStaffName(), 'added', 'a new theme', $theme_name]
                        )
                    );

                    flash()->set('success', sprintf(lang('system::themes.alert_success'), "Theme {$theme_name} added "));

                    return TRUE;
                }

                $this->alert->danger_now(is_string($extractedPath) ?
                    sprintf(lang('system::themes.alert_error'), $extractedPath) : lang('system::themes.error_config_no_found'));
            }
        }

        return FALSE;
    }

    protected function validateUpload()
    {
        if (!empty($_FILES['theme_zip']['name']) AND !empty($_FILES['theme_zip']['tmp_name'])) {

            if (preg_match('/\s/', $_FILES['theme_zip']['name'])) {
                $this->alert->danger_now(lang('system::themes.error_upload_name'));

                return FALSE;
            }

            if ($_FILES['theme_zip']['type'] !== 'application/zip') {
                $this->alert->danger_now(lang('system::themes.error_upload_type'));

                return FALSE;
            }

            $_FILES['theme_zip']['name'] = html_entity_decode($_FILES['theme_zip']['name'], ENT_QUOTES, 'UTF-8');
            $_FILES['theme_zip']['name'] = str_replace(['"', "'", "/", "\\"], "", $_FILES['theme_zip']['name']);
            $filename = $this->security->sanitize_filename($_FILES['theme_zip']['name']);
            $_FILES['theme_zip']['name'] = basename($filename, '.zip');

            if (!empty($_FILES['theme_zip']['error'])) {
                $this->alert->danger_now(lang('system::themes.error_php_upload').$_FILES['theme_zip']['error']);

                return FALSE;
            }

            if (file_exists(ROOTPATH.MAINDIR.'/views/themes/'.$_FILES['theme_zip']['name'])) {
                $this->alert->danger_now(sprintf(lang('system::themes.alert_error'), lang('system::themes.error_theme_exists')));

                return FALSE;
            }

            if (is_uploaded_file($_FILES['theme_zip']['tmp_name'])) {
                return TRUE;
            }

            return FALSE;
        }
    }

    protected function validateForm($is_customizable = FALSE)
    {
        if ($is_customizable) {
            $rules = $this->customizer->getRules();
        }

        $rules['editor_area'] = ['field' => 'editor_area', 'label' => 'Editor area'];

        return $this->validatePasses(post(), $rules);
    }
}