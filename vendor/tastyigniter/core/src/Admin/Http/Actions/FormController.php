<?php

declare(strict_types=1);

namespace Igniter\Admin\Http\Actions;

use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Traits\FormExtendable;
use Igniter\Admin\Traits\PopulatesModelAttributes;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\System\Classes\ControllerAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Form Controller Class
 */
class FormController extends ControllerAction
{
    use FormExtendable;
    use PopulatesModelAttributes;
    use ValidatesForm;

    /** Default context for "create" pages. */
    const CONTEXT_CREATE = 'create';

    /** Default context for "edit" pages. */
    const CONTEXT_EDIT = 'edit';

    /** Default context for "preview" pages. */
    const CONTEXT_PREVIEW = 'preview';

    /** Define controller list configuration array. */
    public array $formConfig;

    protected ?Form $formWidget = null;

    protected ?Toolbar $toolbarWidget = null;

    protected array $requiredProperties = ['formConfig'];

    /**
     * Configuration values that must exist when applying the primary config file.
     * - modelClass: Class name for the model
     * - form: Form field configs
     */
    protected array $requiredConfig = ['model', 'configFile'];

    /** The context to pass to the form widget. */
    protected null|string|array $context = null;

    /** The initialized model used by the form. */
    protected ?Model $model = null;

    /** List of prepared models that require saving. */
    protected array $modelsToSave = [];

    public function __construct($controller = null)
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
     */
    public function initForm(Model $model, ?string $context = null): void
    {
        if ($context !== null) {
            $this->context = $context;
        }

        $context = $this->getFormContext();

        // Each page can supply a unique form config, if desired
        $configFile = $this->config['configFile'];
        $configFile = $this->getConfig($context.'[configFile]', $configFile);

        // Prep the list widget config
        $requiredConfig = ['form'];
        $modelConfig = $this->loadConfig($configFile, $requiredConfig, 'form');
        $formConfig = array_except($modelConfig, 'toolbar');
        $formConfig['model'] = $model;
        $formConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $formConfig['context'] = $context;
        $formConfig['previewMode'] = $context === static::CONTEXT_PREVIEW;

        $this->controller->formExtendConfig($formConfig);

        /** @var Form $formWidget */
        $formWidget = $this->makeWidget(Form::class, $formConfig);
        $this->formWidget = $formWidget;

        $formWidget->bindEvent('form.extendFieldsBefore', function() {
            $this->controller->formExtendFieldsBefore($this->formWidget);
        });

        $formWidget->bindEvent('form.extendFields', function($fields) {
            $this->controller->formExtendFields($this->formWidget, $fields);
        });

        $formWidget->bindEvent('form.beforeRefresh', function($holder) {
            $result = $this->controller->formExtendRefreshData($this->formWidget, $holder->data);
            if (is_array($result)) {
                $holder->data = $result;
            }
        });

        $formWidget->bindEvent('form.refreshFields', fn($fields) => $this->controller->formExtendRefreshFields($this->formWidget, $fields));

        $formWidget->bindEvent('form.refresh', fn($result) => $this->controller->formExtendRefreshResults($this->formWidget, $result));

        $formWidget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar'], $this->controller->widgets['toolbar'])) {
            $this->toolbarWidget = $this->controller->widgets['toolbar'];
            $this->toolbarWidget->reInitialize($modelConfig['toolbar']);
        }

        $this->model = $model;
        $this->prepareVars();
    }

    protected function prepareVars()
    {
        $this->controller->vars['formModel'] = $this->model;
        $this->controller->vars['formContext'] = $this->getFormContext();
        $this->controller->vars['formRecordName'] = lang($this->getConfig('name', 'form_name'));
    }

    public function create(?string $context = null): void
    {
        $this->context = $context ?: $this->getConfig('create[context]', self::CONTEXT_CREATE);

        $this->setFormTitle('lang:igniter::admin.form.create_title');

        $model = $this->controller->formCreateModelObject();
        $model = $this->controller->formExtendModel($model) ?: $model;
        $this->initForm($model, $context);
    }

    public function create_onSave(?string $context = null): ?RedirectResponse
    {
        $context = $context ?: $this->getConfig('create[context]', self::CONTEXT_CREATE);
        $this->context = $context;

        $model = $this->controller->formCreateModelObject();
        $model = $this->controller->formExtendModel($model) ?: $model;
        $this->initForm($model, $context);

        $this->controller->formBeforeSave($model);
        $this->controller->formBeforeCreate($model);

        if (($saveData = $this->validateSaveData($model, $this->formWidget->getSaveData())) === false) {
            return null;
        }

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function() use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->save();
            }
        });

        $this->controller->formAfterSave($model);
        $this->controller->formAfterCreate($model);

        $title = sprintf(lang('igniter::admin.form.create_success'), lang($this->getConfig('name')));
        flash()->success(lang($this->getConfig('create[flashSave]', $title)));

        return $this->makeRedirect($context, $model) ?: null;
    }

    public function edit(?string $context = null, mixed $recordId = null): void
    {
        $context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);
        $this->context = $context;
        $this->setFormTitle('lang:igniter::admin.form.edit_title');

        $model = $this->controller->formFindModelObject($recordId);

        $this->initForm($model, $context);
    }

    public function edit_onSave(?string $context = null, mixed $recordId = null): ?RedirectResponse
    {
        $context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);
        $this->context = $context;

        $model = $this->controller->formFindModelObject($recordId);
        $this->initForm($model, $context);

        $this->controller->formBeforeSave($model);
        $this->controller->formBeforeUpdate($model);

        if (($saveData = $this->validateSaveData($model, $this->formWidget->getSaveData())) === false) {
            return null;
        }

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function() use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->save();
            }
        });

        $this->controller->formAfterSave($model);
        $this->controller->formAfterUpdate($model);

        $title = sprintf(lang('igniter::admin.form.edit_success'), lang($this->getConfig('name')));
        flash()->success(lang($this->getConfig('edit[flashSave]', $title)));

        return $this->makeRedirect($context, $model) ?: null;
    }

    public function edit_onDelete(?string $context = null, mixed $recordId = null): ?RedirectResponse
    {
        $context = $context ?: $this->getConfig('edit[context]', self::CONTEXT_EDIT);
        $this->context = $context;

        $model = $this->controller->formFindModelObject($recordId);
        $this->initForm($model, $context);

        if (!$model->delete()) {
            flash()->warning(lang('igniter::admin.form.delete_failed'));
        } else {
            $this->controller->formAfterDelete($model);

            $title = lang($this->getConfig('name'));
            flash()->success(sprintf(lang($this->getConfig('edit[flashDelete]', 'igniter::admin.form.delete_success')), $title));
        }

        return $this->makeRedirect('delete', $model) ?: null;
    }

    public function preview(?string $context = null, mixed $recordId = null): void
    {
        $context = $context ?: $this->getConfig('preview[context]', self::CONTEXT_PREVIEW);
        $this->context = $context;
        $this->setFormTitle('lang:igniter::admin.form.preview_title');

        $model = $this->controller->formFindModelObject($recordId);
        $this->initForm($model, $context);
    }

    //
    // Utils
    //

    public function renderForm(array $options = [], bool $noToolbar = false): string
    {
        throw_unless($this->formWidget, new FlashException(lang('igniter::admin.form.not_ready')));

        if (!$noToolbar && !is_null($this->toolbarWidget)) {
            $form[] = $this->toolbarWidget->render();
        }

        $form[] = $this->formWidget->render($options);

        return implode(PHP_EOL, $form);
    }

    public function renderFormToolbar(): ?string
    {
        return $this->toolbarWidget?->render() ?: null;
    }

    /**
     * Returns the model initialized by this form behavior.
     */
    public function getFormModel(): ?Model
    {
        return $this->model;
    }

    /**
     * Returns the form context from the postback or configuration.
     */
    public function getFormContext(): ?string
    {
        return post('form_context', $this->context);
    }

    protected function setFormTitle(?string $default = null)
    {
        $title = lang($this->getConfig('name', 'igniter::admin.form.name'));
        $lang = lang($this->getConfig($this->context.'[title]', $default));

        $pageTitle = str_contains($lang, ':name')
            ? str_replace(':name', $title, $lang) : $lang;

        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        if ($backUrl = $this->getConfig($this->context.'[back]', $this->getConfig($this->context.'[redirectClose]'))) {
            AdminMenu::setPreviousUrl($backUrl);
        }
    }

    /**
     * Internal method, prepare the form model object
     */
    protected function createModel(): Model
    {
        $class = $this->config['model'];

        return new $class;
    }

    /**
     * Returns a Redirect object based on supplied context and parses the model primary key.
     */
    public function makeRedirect(?string $context = null, ?Model $model = null): ?RedirectResponse
    {
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

        return $redirectUrl !== '' && $redirectUrl !== '0' ? $this->controller->redirect($redirectUrl) : null;
    }

    /**
     * Internal method, returns a redirect URL from the config based on
     * supplied context. Otherwise the default redirect is used.
     *
     * @param ?string $context Redirect context, eg: create, edit, delete.
     */
    protected function getRedirectUrl(?string $context = null): string
    {
        $redirectContext = explode('-', (string)$context, 2)[0];
        $redirectAction = explode('-', (string)$context, 2)[1] ?? '';
        $redirectSource = in_array($redirectAction, ['new', 'close'], true)
            ? 'redirect'.studly_case($redirectAction)
            : 'redirect';

        $redirects = [$context => $this->getConfig(sprintf('%s[%s]', $redirectContext, $redirectSource), '')];
        $redirects['default'] = $this->getConfig('defaultRedirect', '');

        return $redirects[$context] ?? $redirects['default'];
    }

    protected function validateSaveData(Model $model, mixed $saveData): bool|array
    {
        if (!is_null($requestClass = $this->getConfig($this->context.'[request]', $this->getConfig('request')))) {
            return $this->validateFormRequest($requestClass, function(FormRequest $request) use ($saveData) {
                $request->merge($saveData);
            });
        }

        if (($validated = $this->controller->formValidate($model, $this->formWidget)) === false) {
            return false;
        }

        return $validated ?? $saveData;
    }
}
