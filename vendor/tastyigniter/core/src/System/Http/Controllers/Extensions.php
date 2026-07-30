<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Classes\ListColumn;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Traits\WidgetMaker;
use Igniter\Admin\Widgets\Form;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Actions\SettingsModel;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Models\Extension;
use Igniter\System\Models\Settings;
use Igniter\System\Traits\ManagesUpdates;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;

class Extensions extends AdminController
{
    use ManagesUpdates;
    use WidgetMaker;

    public array $implement = [
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Extension::class,
            'title' => 'lang:igniter::system.extensions.text_title',
            'emptyMessage' => 'lang:igniter::system.extensions.text_empty',
            'pageLimit' => 50,
            'defaultSort' => ['name', 'ASC'],
            'showCheckboxes' => false,
            'configFile' => 'extension',
        ],
    ];

    protected null|string|array $requiredPermissions = ['Admin.Extensions', 'edit' => ['Site.Settings']];

    public ?Form $formWidget = null;

    public ?Toolbar $toolbarWidget = null;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('extensions', 'system');
    }

    public function index(): void
    {
        Extension::syncAll();

        $this->initUpdate('extension');

        $this->asExtension('ListController')->index();
    }

    public function edit(?string $action, ?string $vendor = null, ?string $extension = null, ?string $context = null): void
    {
        AdminMenu::setContext('settings', 'system');
        AdminMenu::setPreviousUrl('settings');

        throw_if(!strlen((string)$vendor) || !strlen((string)$extension),
            new FlashException(lang('igniter::system.extensions.alert_setting_missing_id')),
        );

        $extensionCode = $vendor.'.'.$extension.'.'.$context;
        throw_if(!$settingItem = (new Settings)->getSettingItem($extensionCode),
            new FlashException(lang('igniter::system.extensions.alert_setting_not_found')),
        );

        throw_if($settingItem->permissions && !$this->getUser()->hasPermission($settingItem->permissions),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        $pageTitle = lang($settingItem->label ?: 'text_edit_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $model = $this->formFindModelObject($settingItem);

        $this->initFormWidget($model, $action);
    }

    public function delete(string $context, ?string $extensionCode = null): ?RedirectResponse
    {
        $pageTitle = lang('igniter::system.extensions.text_delete_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $extensionManager = resolve(ExtensionManager::class);
        $extensionClass = $extensionManager->findExtension($extensionCode);

        // Extension not found in filesystem
        // so delete from database
        if (!$extensionClass) {
            $extensionManager->deleteExtension($extensionCode);
            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Extension deleted '));

            return $this->redirectBack();
        }

        // Extension must be disabled before it can be deleted
        if (!$extensionClass->disabled) {
            flash()->warning(sprintf(lang('igniter::admin.alert_error_nothing'), lang('igniter::admin.text_deleted').lang('igniter::system.extensions.alert_is_installed')));

            return $this->redirectBack();
        }

        // Lets display a delete confirmation screen
        // with list of files to be deleted
        $meta = $extensionClass->extensionMeta();
        $this->vars['extensionModel'] = Extension::where('name', $extensionCode)->first();
        $this->vars['extensionMeta'] = $meta;
        $this->vars['extensionName'] = $meta['name'] ?? '';
        $this->vars['extensionData'] = $this->extensionHasMigrations($extensionCode);

        return null;
    }

    public function index_onLoadReadme(?string $context = null): string
    {
        if (empty($recordId = trim((string)post('recordId')))) {
            throw new FlashException(lang('igniter::admin.alert_error_try_again'));
        }

        return $this->makePartial('extensions/extension_readme', [
            'record' => Extension::find($recordId),
        ]);
    }

    public function index_onInstall(?string $context = null): RedirectResponse
    {
        if (empty($extensionCode = trim((string)(post('code') ?: '')))) {
            throw new FlashException(lang('igniter::admin.alert_error_try_again'));
        }

        $manager = resolve(ExtensionManager::class);
        $extension = $manager->findExtension($extensionCode);

        if ($manager->installExtension($extensionCode)) {
            $title = array_get($extension->extensionMeta(), 'name');
            flash()->success(sprintf(lang('igniter::admin.alert_success'), sprintf('Extension %s installed ', $title)));
        } else {
            flash()->danger(lang('igniter::admin.alert_error_try_again'));
        }

        return $this->redirectBack();
    }

    public function index_onUninstall(?string $context = null): RedirectResponse
    {
        if (empty($extensionCode = trim((string)(post('code') ?: '')))) {
            throw new FlashException(lang('igniter::admin.alert_error_try_again'));
        }

        $manager = resolve(ExtensionManager::class);
        $extension = $manager->findExtension($extensionCode);

        throw_if($manager->isRequired($extensionCode), new FlashException(
            lang('igniter::system.extensions.alert_is_required'),
        ));

        if ($manager->uninstallExtension($extensionCode)) {
            $title = $extension ? array_get($extension->extensionMeta(), 'name') : $extensionCode;
            flash()->success(sprintf(lang('igniter::admin.alert_success'), sprintf('Extension %s uninstalled ', $title)));
        } else {
            flash()->danger(lang('igniter::admin.alert_error_try_again'));
        }

        return $this->redirectBack();
    }

    public function edit_onSave(string $action, ?string $vendor = null, ?string $extension = null, ?string $context = null): array|false|RedirectResponse
    {
        throw_if(!strlen((string)$vendor) || !strlen((string)$extension),
            new FlashException(lang('igniter::system.extensions.alert_setting_missing_id')),
        );

        $extensionCode = $vendor.'.'.$extension.'.'.$context;
        throw_unless($settingItem = (new Settings)->getSettingItem($extensionCode),
            new FlashException(lang('igniter::system.extensions.alert_setting_not_found')),
        );

        throw_if($settingItem->permissions && !$this->getUser()->hasPermission($settingItem->permissions),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        $model = $this->formFindModelObject($settingItem);

        $this->initFormWidget($model, $action);

        $saveData = $this->formWidget->getSaveData();

        if ($settingItem->request) {
            $this->validateFormRequest($settingItem->request, function(HttpRequest $request) use ($saveData) {
                $request->merge($saveData);
            });
        }

        if ($this->formValidate($model, $this->formWidget) === false) {
            return Request::ajax() ? ['#notification' => $this->makePartial('flash')] : false;
        }

        /** @var SettingsModel $model */
        if ($model->set($saveData)) {
            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($settingItem->label).' settings updated '));
        }

        if (post('close')) {
            return $this->redirect('settings');
        }

        return $this->refresh();
    }

    public function delete_onDelete(?string $context = null, ?string $extensionCode = null): RedirectResponse
    {
        $manager = resolve(ExtensionManager::class);
        if (!$extension = $manager->findExtension($extensionCode)) {
            throw new FlashException(lang('igniter::admin.alert_error_try_again'));
        }

        $purgeData = post('delete_data') == 1;
        $manager->deleteExtension($extensionCode, $purgeData);

        $title = array_get($extension->extensionMeta(), 'name');
        flash()->success(sprintf(lang('igniter::admin.alert_success'), sprintf('Extension %s deleted ', $title)));

        return $this->redirect('extensions');
    }

    public function listOverrideColumnValue(Extension $record, ListColumn $column, ?string $alias = null): ?array
    {
        if ($column->type !== 'button') {
            return null;
        }

        if (($column->columnName === 'delete' && $record->status)
            || ($column->columnName === 'uninstall' && $record->required)
            || ($column->columnName !== 'delete' && !$record->class)
        ) {
            $attributes = $column->attributes;
            $attributes['class'] .= ' disabled';

            return $attributes;
        }

        return null;
    }

    protected function initFormWidget(Model $model, ?string $context = null)
    {
        /** @var SettingsModel $model */
        $config = $model->getFieldConfig();

        $modelConfig = array_except($config, 'toolbar');
        $modelConfig['model'] = $model;
        $modelConfig['arrayName'] = str_singular(strip_class_basename($model, '_model'));
        $modelConfig['context'] = $context;

        // Form Widget with extensibility
        /** @var Form $formWidget */
        $formWidget = $this->makeWidget(Form::class, $modelConfig);
        $formWidget->bindToController();
        $this->formWidget = $formWidget;

        // Prep the optional toolbar widget
        if (isset($config['toolbar'], $this->widgets['toolbar'])) {
            /** @var Toolbar $toolbarWidget */
            $toolbarWidget = $this->widgets['toolbar'];
            $toolbarWidget->reInitialize($config['toolbar']);
            $this->toolbarWidget = $toolbarWidget;
        }
    }

    protected function createModel(string $class): Model
    {
        throw_unless(strlen($class),
            new FlashException(lang('igniter::system.extensions.alert_setting_model_missing')),
        );

        throw_unless(class_exists($class),
            new FlashException(sprintf(lang('igniter::system.extensions.alert_setting_model_not_found'), $class)),
        );

        return new $class;
    }

    protected function formFindModelObject($settingItem): Model
    {
        /** @var SettingsModel $model */
        $model = $this->createModel($settingItem->model);

        // Prepare query and find model record
        $result = $model->getSettingsRecord();

        return $result ?: $model;
    }

    protected function formValidate(Model $model, Form $form): array|false|null
    {
        if (!isset($form->config['rules'])) {
            return null;
        }

        return $this->validatePasses($form->getSaveData(),
            $form->config['rules'],
            array_get($form->config, 'validationMessages', []),
            array_get($form->config, 'validationAttributes', []),
        );
    }

    protected function extensionHasMigrations(string $extensionCode): bool
    {
        return array_key_exists($extensionCode, Igniter::migrationPath());
    }
}
