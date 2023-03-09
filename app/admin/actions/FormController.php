<?php

namespace Admin\Actions;

use Admin\Classes\AdminController;
use Admin\Classes\FormField;
use Admin\Facades\Template;
use Admin\Traits\FormExtendable;
use Admin\Widgets\Toolbar;
use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use System\Classes\ControllerAction;

/**
 * Form Controller Class
 */
class FormController extends ControllerAction
{
    use FormExtendable;

    /**
     * @var string Default context for "create" pages.
     */
    const CONTEXT_CREATE = 'create';

    /**
     * @var string Default context for "edit" pages.
     */
    const CONTEXT_EDIT = 'edit';

    /**
     * @var string Default context for "preview" pages.
     */
    const CONTEXT_PREVIEW = 'preview';

    /**
     * @var AdminController|FormController Reference to the back end controller.
     */
    protected $controller;

    /**
     * Define controller list configuration array.
     * @var array
     */
    public $formConfig;

    /**
     * @var \Admin\Widgets\Form Reference to the widget object.
     */
    protected $formWidget;

    /**
     * @var \Admin\Classes\BaseWidget Reference to the toolbar widget objects.
     */
    protected $toolbarWidget;

    protected $requiredProperties = ['formConfig'];

    /**
     * @var array Configuration values that must exist when applying the primary config file.
     * - modelClass: Class name for the model
     * - form: Form field configs
     */
    protected $requiredConfig = ['model', 'configFile'];

    /**
     * @var string The context to pass to the form widget.
     */
    protected $context;

    /**
     * @var Model The initialized model used by the form.
     */
    protected $model;

    /**
     * @var Model The initialized request used by the form.
     */
    protected $request;

    /**
     * @var array List of prepared models that require saving.
     */
    protected $modelsToSave = [];

    /**
     * FormController constructor.
     *
     * @param AdminController $controller
     *
     * @throws \Exception
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->formConfig = $controller->formConfig;
        $this->setConfig($controller->formConfig, $this->requiredConfig);

        $flippedContextArray = array_flip([static::CONTEXT_CREATE, static::CONTEXT_EDIT, static::CONTEXT_PREVIEW]);
        $mergeHiddenAction = array_flip(array_diff_key($flippedContextArray, array_flip(array_keys($this->formConfig))));

        // Safe to hide all public method ?
        $this->hideAction(array_merge($mergeHiddenAction, [
            'create_onSave',
            'edit_onSave',
            'edit_onDelete',
            'renderForm',
            'getFormModel',
            'getFormContext',
            'formValidate',
            'formBeforeSave',
            'formAfterSave',
            'formBeforeCreate',
            'formAfterCreate',
            'formBeforeUpdate',
            'formAfterUpdate',
            'formAfterDelete',
            'formFindModelObject',
            'formCreateModelObject',
            'formExtendFieldsBefore',
            'formExtendFields',
            'formExtendRefreshData',
            'formExtendRefreshFields',
            'formExtendRefreshResults',
            'formExtendModel',
            'formExtendQuery',
            'extendFormFields',
        ]));
    }

    /**
     * Prepare the widgets used by this action
     *
     * @param \Igniter\Flame\Database\Model $model
     *
     * @param null $context
     * @return void
     * @throws \Exception
     */
    public function initForm($model, $context = null)
    {
        if ($context !== null)
            $this->context = $context;

        $context = $this->getFormContext();

        // Each page can supply a unique form config, if desired
        $configFile = $this->config['configFile'];

        if ($context == self::CONTEXT_CREATE) {
            $configFile = $this->getConfig('create[configFile]', $configFile);
        }
        elseif ($context == self::CONTEXT_EDIT) {
            $configFile = $this->getConfig('edit[configFile]', $configFile);
        }
        elseif ($context == self::CONTEXT_PREVIEW) {
            $configFile = $this->getConfig('preview[configFile]', $configFile);
        }

        // Prep the list widget config
        $requiredConfig = ['form'];
        $modelConfig = $this->loadConfig($configFile, $requiredConfig, 'form');
        $formConfig = array_except($modelConfig, 'toolbar');
        $formConfig['model'] = $model;
        $formConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $formConfig['context'] = $context;

        $this->controller->formExtendConfig($formConfig);

        // Form Widget with extensibility
        $this->formWidget = $this->makeWidget('Admin\Widgets\Form', $formConfig);

        $this->formWidget->bindEvent('form.extendFieldsBefore', function () {
            $this->controller->formExtendFieldsBefore($this->formWidget);
        });

        $this->formWidget->bindEvent('form.extendFields', function ($fields) {
            $this->controller->formExtendFields($this->formWidget, $fields);
        });

        $this->formWidget->bindEvent('form.beforeRefresh', function ($holder) {
            $result = $this->controller->formExtendRefreshData($this->formWidget, $holder->data);
            if (is_array($result)) $holder->data = $result;
        });

        $this->formWidget->bindEvent('form.refreshFields', function ($fields) {
            return $this->controller->formExtendRefreshFields($this->formWidget, $fields);
        });

        $this->formWidget->bindEvent('form.refresh', function ($result) {
            return $this->controller->formExtendRefreshResults($this->formWidget, $result);
        });

        $this->formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar']) && isset($this->controller->widgets['toolbar'])) {
            $this->toolbarWidget = $this->controller->widgets['toolbar'];
            if ($this->toolbarWidget instanceof Toolbar) {
                $this->toolbarWidget->reInitialize($modelConfig['toolbar']);
            }
        }

        $this->prepareVars($model);
        $this->model = $model;
    }

    /**
     * Prepares common form data
     * @param $model
     */
    protected function prepareVars($model)
    {
        $this->controller->vars['formModel'] = $model;
        $this->controller->vars['formContext'] = $this->getFormContext();
        $this->controller->vars['formRecordName'] = lang($this->getConfig('name', 'form_name'));
    }

    public function create($context = null)
    {
        try {
            $this->context = $context ?: $this->getConfig('create[context]', self::CONTEXT_CREATE);

            $this->setFormTitle('lang:admin::lang.form.create_title');

            $model = $this->controller->formCreateModelObject();
            $model = $this->controller->formExtendModel($model) ?: $model;
            $this->initForm($model, $context);
        }
        catch (Exception $ex) {
            $this->controller->handleError($ex);
        }
    }

    public function create_onSave($context = null)
    {
        $this->context = $context ?: $this->getConfig('create[context]', self::CONTEXT_CREATE);
        $model = $this->controller->formCreateModelObject();
        $model = $this->controller->formExtendModel($model) ?: $model;
        $this->initForm($model, $context);

        $this->controller->formBeforeSave($model);
        $this->controller->formBeforeCreate($model);

        $modelsToSave = $this->prepareModelsToSave($model, $this->formWidget->getSaveData());

        $this->validateFormRequest($model);

        if ($this->controller->formValidate($model, $this->formWidget) === false)
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : false;

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->save();
            }
        });

        $this->controller->formAfterSave($model);
        $this->controller->formAfterCreate($model);

        $title = sprintf(lang('admin::lang.form.create_success'), lang($this->getConfig('name')));
        flash()->success(lang($this->getConfig('create[flashSave]', $title)));

        if ($redirect = $this->makeRedirect($context, $model)) {
            return $redirect;
        }
    }

    public function edit($context = null, $recordId = null)
    {
        try {
            $this->context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);

            $this->setFormTitle('lang:admin::lang.form.edit_title');

            $model = $this->controller->formFindModelObject($recordId);

            $this->initForm($model, $context);
        }
        catch (Exception $ex) {
            $this->controller->handleError($ex);
        }
    }

    public function edit_onSave($context = null, $recordId = null)
    {
        $this->context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);

        $model = $this->controller->formFindModelObject($recordId);
        $this->initForm($model, $context);

        $this->controller->formBeforeSave($model);
        $this->controller->formBeforeUpdate($model);

        $modelsToSave = $this->prepareModelsToSave($model, $this->formWidget->getSaveData());

        $this->validateFormRequest($model);

        if ($this->controller->formValidate($model, $this->formWidget) === false)
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : false;

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->save();
            }
        });

        $this->controller->formAfterSave($model);
        $this->controller->formAfterUpdate($model);

        $title = sprintf(lang('admin::lang.form.edit_success'), lang($this->getConfig('name')));
        flash()->success(lang($this->getConfig('edit[flashSave]', $title)));

        if ($redirect = $this->makeRedirect($context, $model)) {
            return $redirect;
        }
    }

    public function edit_onDelete($context = null, $recordId = null)
    {
        $this->context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);

        $model = $this->controller->formFindModelObject($recordId);
        $this->initForm($model, $context);

        if (!$model->delete()) {
            flash()->warning(lang('admin::lang.form.delete_failed'));
        }
        else {
            $this->controller->formAfterDelete($model);

            $title = lang($this->getConfig('name'));
            flash()->success(sprintf(lang($this->getConfig('edit[flashDelete]', 'admin::lang.form.delete_success')), $title));
        }

        if ($redirect = $this->makeRedirect('delete', $model)) {
            return $redirect;
        }
    }

    public function preview($context = null, $recordId = null)
    {
        try {
            $this->context = $context ?: $this->getConfig('preview[context]', self::CONTEXT_PREVIEW);

            $this->setFormTitle('lang:admin::lang.form.preview_title');

            $model = $this->controller->formFindModelObject($recordId);
            $this->initForm($model, $context);
        }
        catch (Exception $ex) {
            $this->controller->handleError($ex);
        }
    }

    //
    // Utils
    //

    /**
     * Render the form.
     *
     * @param array $options Custom options to pass to the form widget.
     *
     * @return string Rendered HTML for the form.
     * @throws \Exception
     */
    public function renderForm($options = [])
    {
        if (!$this->formWidget) {
            throw new Exception(lang('admin::lang.form.not_ready'));
        }

        if (!is_null($this->toolbarWidget)) {
            $form[] = $this->toolbarWidget->render();
        }

        $form[] = $this->formWidget->render($options);

        return implode(PHP_EOL, $form);
    }

    /**
     * Returns the model initialized by this form behavior.
     * @return Model
     */
    public function getFormModel()
    {
        return $this->model;
    }

    /**
     * Returns the form context from the postback or configuration.
     * @return string
     */
    public function getFormContext()
    {
        if ($context = post('form_context'))
            return $context;

        return $this->context;
    }

    protected function setFormTitle($default)
    {
        $title = lang($this->getConfig('name'));
        $lang = lang($this->getConfig($this->context.'[title]', $default));

        $pageTitle = (strpos($lang, ':name') !== false)
            ? str_replace(':name', $title, $lang) : $lang;

        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);
    }

    /**
     * Internal method, prepare the form model object
     * @return Model
     */
    protected function createModel()
    {
        $class = $this->config['model'];

        return new $class;
    }

    /**
     * Returns a Redirect object based on supplied context and parses the model primary key.
     *
     * @param string $context Redirect context, eg: create, edit, delete
     * @param Model $model The active model to parse in it's ID and attributes.
     *
     * @return Redirect
     */
    public function makeRedirect($context = null, $model = null)
    {
        $redirectUrl = null;
        if (post('new') && !ends_with($context, '-new')) {
            $context .= '-new';
        }

        if (post('close') && !ends_with($context, '-close')) {
            $context .= '-close';
        }

        if (post('refresh', false)) {
            return $this->controller->refresh();
        }

        $redirectUrl = $this->getRedirectUrl($context);

        if ($model && $redirectUrl) {
            $redirectUrl = parse_values($model->getAttributes(), $redirectUrl);
        }

        return $redirectUrl ? $this->controller->redirect($redirectUrl) : null;
    }

    /**
     * Internal method, returns a redirect URL from the config based on
     * supplied context. Otherwise the default redirect is used.
     *
     * @param string $context Redirect context, eg: create, edit, delete.
     *
     * @return string
     */
    protected function getRedirectUrl($context = null)
    {
        $redirectContext = explode('-', $context, 2)[0];
        $redirectAction = explode('-', $context, 2)[1] ?? '';
        $redirectSource = in_array($redirectAction, ['new', 'close'])
            ? 'redirect'.studly_case($redirectAction)
            : 'redirect';

        $redirects = [$context => $this->getConfig("{$redirectContext}[{$redirectSource}]", '')];
        $redirects['default'] = $this->getConfig('defaultRedirect', '');

        return $redirects[$context] ?? $redirects['default'];
    }

    protected function prepareModelsToSave($model, $saveData)
    {
        $this->modelsToSave = [];
        $this->setModelAttributes($model, $saveData);

        return $this->modelsToSave;
    }

    /**
     * Sets a data collection to a model attributes, relations will also be set.
     *
     * @param \Igniter\Flame\Database\Model $model Model to save to
     *
     * @param array $saveData Data to save.
     *
     * @return void
     */
    protected function setModelAttributes($model, $saveData)
    {
        if (!is_array($saveData) || !$model) {
            return;
        }

        $this->modelsToSave[] = $model;

        $singularTypes = ['belongsTo', 'hasOne', 'morphOne'];
        foreach ($saveData as $attribute => $value) {
            $isNested = ($attribute == 'pivot' || (
                    $model->hasRelation($attribute) &&
                    in_array($model->getRelationType($attribute), $singularTypes)
                ));

            if ($isNested && is_array($value) && $model->{$attribute}) {
                $this->setModelAttributes($model->{$attribute}, $value);
            }
            elseif ($value !== FormField::NO_SAVE_DATA) {
                if (!starts_with($attribute, '_'))
                    $model->{$attribute} = $value;
            }
        }
    }

    protected function validateFormRequest($model)
    {
        $requestClass = $this->getConfig('request', false);

        if ($requestClass === false)
            return;

        if (!class_exists($requestClass))
            throw new ApplicationException(sprintf(lang('admin::lang.form.request_class_not_found'), $requestClass));

        $this->resolveFormRequest($requestClass);
    }

    protected function resolveFormRequest($requestClass)
    {
        app()->resolving($requestClass, function ($request, $app) {
            if (method_exists($request, 'setController'))
                $request->setController($this->controller);

            if (method_exists($request, 'setInputKey'))
                $request->setInputKey(strip_class_basename($request));
        });

        return app()->make($requestClass);
    }
}
