<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Classes\ListColumn;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Database\Model;
use Igniter\System\Classes\LanguageManager;
use Igniter\System\Http\Requests\LanguageRequest;
use Igniter\System\Models\Language;
use Igniter\System\Traits\ManagesUpdates;
use Igniter\System\Traits\SessionMaker;

class Languages extends AdminController
{
    use ManagesUpdates;
    use SessionMaker;

    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Language::class,
            'title' => 'lang:igniter::system.languages.text_title',
            'emptyMessage' => 'lang:igniter::system.languages.text_empty',
            'defaultSort' => ['language_id', 'DESC'],
            'configFile' => 'language',
            'back' => 'settings',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::system.languages.text_form_name',
        'model' => Language::class,
        'request' => LanguageRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
            'redirectNew' => 'languages/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
            'redirectNew' => 'languages/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'languages',
        ],
        'delete' => [
            'redirect' => 'languages',
        ],
        'configFile' => 'language',
    ];

    protected null|string|array $requiredPermissions = 'Site.Languages';

    protected ?array $localeFiles = null;

    protected int $totalStrings = 0;

    protected int $totalTranslated = 0;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index(): void
    {
        Language::applySupportedLanguages();

        $this->initUpdate('language');

        $this->asExtension('ListController')->index();
    }

    public function edit(?string $context = null, ?string $recordId = null): void
    {
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('formwidgets/translationseditor.js', 'translationseditor-js');

        $this->prepareAssets();

        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function index_onSetDefault(?string $context = null)
    {
        $data = $this->validate(post(), [
            'default' => 'required|string|exists:'.Language::class.',code',
        ]);

        if (Language::updateDefault($data['default'])) {
            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter::system.languages.alert_set_default')));
        }

        return $this->asExtension(ListController::class)->refreshList('list');
    }

    public function listOverrideColumnValue(Language $record, ListColumn $column, ?string $alias = null): void
    {
        if ($column->type === 'button' && $column->columnName === 'default') {
            $column->iconCssClass = $record->isDefault() ? 'fa fa-star' : 'fa fa-star-o';
        }
    }

    public function edit_onSubmitFilter(?string $context = null, ?string $recordId = null)
    {
        $formController = $this->asExtension(FormController::class);
        $model = $formController->formFindModelObject($recordId);

        $formController->initForm($model, $context);

        $group = post('Language._group');
        $this->setFilterValue('group', !$group ? null : $group);

        $term = post('Language._search');
        $this->setFilterValue('search', (!is_string($term) || !$term) ? null : $term);

        $filter = post('Language._filter');
        $this->setFilterValue('filter', (!$filter || !is_string($filter)) ? null : $filter);

        return $formController->makeRedirect('edit', $model);
    }

    public function edit_onCheckUpdates(?string $context = null, ?string $recordId = null): string
    {
        $model = $this->asExtension(FormController::class)->formFindModelObject($recordId);

        $response = resolve(LanguageManager::class)->applyLanguagePack($model->code, (array)$model->version);

        return $this->makePartial('updates', [
            'locale' => $model->code,
            'updates' => $response,
        ]);
    }

    public function edit_onPublishTranslations(?string $context = null, ?string $recordId = null)
    {
        $formController = $this->asExtension(FormController::class);
        $model = $formController->formFindModelObject($recordId);

        resolve(LanguageManager::class)->publishTranslations($model);

        flash()->success(lang('igniter::system.languages.alert_publish_success'));

        return $formController->makeRedirect('edit', $model);
    }

    public function edit_onApplyUpdate(?string $context = null, ?string $recordId = null): array
    {
        $formController = $this->asExtension(FormController::class);

        /** @var Language $model */
        $model = $formController->formFindModelObject($recordId);

        $success = true;
        $messages = [];
        $languageManager = resolve(LanguageManager::class);
        $itemsToUpdate = $languageManager->applyLanguagePack($model->code, (array)$model->version);
        foreach ($itemsToUpdate as $item) {
            foreach (array_get($item, 'files', []) as $file) {
                $messages[] = sprintf(lang('igniter::system.languages.alert_update_file_progress'), $model->code, $item['name'], $file['name']);

                try {
                    $languageManager->installLanguagePack($model->code, [
                        'name' => $item['code'],
                        'type' => $item['type'],
                        'ver' => '0.1.0',
                        'file' => $file['name'],
                        'hash' => $file['hash'],
                    ]);
                } catch (Exception $ex) {
                    $messages[] = sprintf(lang('igniter::system.languages.alert_update_file_failed'), $model->code, $item['name'], $file['name']);
                    $messages[] = $ex->getMessage();
                    $success = false;
                }

                $model->updateVersions($item['code'], $file['name'], $file['hash']);

                $messages[] = sprintf(lang('igniter::system.languages.alert_update_file_complete'), $model->code, $item['name'], $file['name']);
            }

            $messages[] = sprintf(lang('igniter::system.languages.alert_update_complete'), $model->code, $item['name']);
        }

        return [
            'message' => implode('<br>', $messages),
            'success' => $success,
            'redirect' => admin_url('languages/edit/'.$model->getKey()),
        ];
    }

    public function formExtendModel(Model $model): void
    {
        /** @var Language $model */
        if (!$model->exists || $model->code === 'en') {
            return;
        }

        Template::setButton(lang('igniter::system.languages.button_import_translations'), [
            'class' => 'btn btn-light pull-right',
            'data-toggle' => 'record-editor',
            'data-handler' => 'onCheckUpdates',
        ]);
    }

    public function formExtendFields(Form $form, array $fields): void
    {
        if ($form->getContext() !== 'edit') {
            return;
        }

        $groupField = $form->getField('_group');
        $searchField = $form->getField('_search');
        $filterField = $form->getField('_filter');
        $field = $form->getField('translations');

        $groupField->value = $this->getFilterValue('group');
        $searchField->value = $this->getFilterValue('search');
        $filterField->value = $this->getFilterValue('filter', 'changed');
        $field->value = $this->getFilterValue('search');

        $field->options = resolve(LanguageManager::class)->listTranslations(
            $form->model, $groupField->value, $filterField->value, $searchField->value,
        );
    }

    protected function getFilterValue(string $key, ?string $default = null): mixed
    {
        return $this->getSession('translation_'.$key, $default);
    }

    protected function setFilterValue(string $key, ?string $value = null)
    {
        if (is_null($value)) {
            $this->forgetSession('translation_'.$key);
        } else {
            $this->putSession('translation_'.$key, trim($value));
        }
    }
}
