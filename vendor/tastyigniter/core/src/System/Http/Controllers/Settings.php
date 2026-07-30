<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Traits\WidgetMaker;
use Igniter\Admin\Widgets\Form;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\Flame\Exception\FlashException;
use Igniter\System\Models\MailTemplate;
use Igniter\System\Models\Settings as SettingsModel;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use stdClass;

class Settings extends AdminController
{
    use WidgetMaker;

    protected null|string|array $requiredPermissions = 'Site.Settings';

    protected $modelClass = SettingsModel::class;

    public ?Form $formWidget = null;

    public ?Toolbar $toolbarWidget = null;

    public ?string $settingCode = null;

    public array $settingItemErrors = [];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index(): void
    {
        MailTemplate::syncAll();

        $this->validateSettingItems(true);

        $pageTitle = lang('igniter::system.settings.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);
        $this->vars['settings'] = $this->createModel()->listSettingItems();
        $this->vars['settingItemErrors'] = $this->settingItemErrors;
    }

    public function edit(string $context, ?string $settingCode = null)
    {
        $this->settingCode = $settingCode;
        [$model, $definition] = $this->findSettingDefinitions($settingCode);

        throw_unless($definition, new FlashException(
            sprintf(lang('igniter::system.settings.alert_settings_not_found'), $settingCode),
        ));

        if ($definition->permissions && !$this->getUser()->hasPermission($definition->permissions)) {
            return Response::make(View::make('igniter.admin::access_denied'), 403);
        }

        $pageTitle = sprintf(lang('igniter::system.settings.text_edit_title'), lang($definition->label));
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);
        AdminMenu::setPreviousUrl('settings');

        $this->initWidgets($model, $definition);

        return null;
    }

    public function edit_onSave(string $context, ?string $settingCode = null)
    {
        $this->settingCode = $settingCode;
        [$model, $definition] = $this->findSettingDefinitions($settingCode);
        throw_unless($definition,
            new FlashException(lang('igniter::system.settings.alert_settings_not_found')),
        );

        if ($definition->permissions && !$this->getUser()->hasPermission($definition->permissions)) {
            return Response::make(View::make('igniter.admin::access_denied'), 403);
        }

        $this->initWidgets($model, $definition);

        $saveData = $this->formWidget->getSaveData();

        if ($definition->request) {
            $this->validateFormRequest($definition->request, function(Request $request) use ($saveData) {
                $request->merge($saveData);
            });
        }

        SettingsModel::set($saveData);

        $this->validateSettingItems(true);

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($definition->label).' settings updated '));

        if (post('close')) {
            return $this->redirect('settings');
        }

        return $this->refresh();
    }

    public function edit_onTestMail(string $context, ?string $settingCode = null): RedirectResponse
    {
        [$model, $definition] = $this->findSettingDefinitions('mail');
        throw_unless($settingCode === 'mail' && $definition,
            new FlashException(lang('igniter::system.settings.alert_settings_not_found')),
        );

        $this->initWidgets($model, $definition);

        $saveData = $this->formWidget->getSaveData();

        if ($definition->request) {
            $this->validateFormRequest($definition->request, function(Request $request) use ($saveData) {
                $request->merge($saveData);
            });
        }

        SettingsModel::set($saveData);

        $name = AdminAuth::getStaffName();
        $email = AdminAuth::getStaffEmail();

        try {
            Mail::raw(lang('igniter::system.settings.text_test_email_message'), function(Message $message) use ($name, $email) {
                $message->to($email, $name)->subject('This a test email');
            });
            SettingsModel::setPref('test_mail_sent', true);

            flash()->success(sprintf(lang('igniter::system.settings.alert_email_sent'), $email));
        } catch (Exception $exception) {
            flash()->error($exception->getMessage());
        }

        return $this->refresh();
    }

    public function initWidgets(SettingsModel $model, stdClass $definition): void
    {
        $modelConfig = $this->getFieldConfig($definition->code, $model);

        $formConfig = array_except($modelConfig, 'toolbar');
        $formConfig['model'] = $model;
        $formConfig['data'] = array_undot($model->getFieldValues());
        $formConfig['alias'] = 'form';
        $formConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $formConfig['context'] = 'edit';

        // Form Widget with extensibility
        /** @var Form $formWidget */
        $formWidget = $this->makeWidget(Form::class, $formConfig);
        $formWidget->bindToController();
        $this->formWidget = $formWidget;

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar'], $this->widgets['toolbar'])) {
            /** @var Toolbar $toolbarWidget */
            $toolbarWidget = $this->widgets['toolbar'];
            $toolbarWidget->reInitialize($modelConfig['toolbar']);
            $this->toolbarWidget = $toolbarWidget;
        }
    }

    protected function findSettingDefinitions(string $code): array
    {
        throw_unless(strlen($code),
            new FlashException(lang('igniter::admin.form.missing_id')),
        );

        // Prep the list widget config
        $model = $this->createModel();

        $definition = $model->getSettingDefinitions($code);

        return [$model, $definition];
    }

    protected function createModel(): SettingsModel
    {
        return resolve($this->modelClass);
    }

    protected function getFieldConfig(string $code, SettingsModel $model): array
    {
        $settingItem = $model->getSettingItem('core.'.$code);
        if ($settingItem->form && !is_array($settingItem->form)) {
            $settingItem->form = array_get($this->makeConfig($settingItem->form, ['form']), 'form', []);
        }

        return $settingItem->form ?? [];
    }

    protected function validateSettingItems(bool $skipSession = false): array
    {
        $settingItemErrors = Session::get('settings.errors', []);

        if ($skipSession || !$settingItemErrors) {
            $model = $this->createModel();
            $settingItems = array_get($model->listSettingItems(), 'core');
            $settingValues = array_undot($model->getFieldValues());

            foreach ($settingItems as $settingItem) {
                if ($settingItem->request) {
                    $request = new $settingItem->request;
                    $rules = $request->rules();
                    $attributes = $request->attributes();
                } else {
                    continue;
                }

                $validator = $this->makeValidator($settingValues, $rules, [], $attributes);
                $errors = $validator->fails() ? $validator->errors() : [];

                $settingItemErrors[$settingItem->code] = $errors;
            }

            Session::put('settings.errors', $settingItemErrors);
        }

        return $this->settingItemErrors = $settingItemErrors;
    }
}
