<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Form Relationship
 */
class Connector extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public const string INDEX_SEARCH = '___index__';

    public const string SORT_PREFIX = '___dragged_';

    //
    // Object properties
    //

    protected string $defaultAlias = 'connector';

    protected ?string $sortableInputName = null;

    //
    // Configurable properties
    //

    public string $sortColumnName = 'priority';

    public string $nameFrom = 'name';

    public string $descriptionFrom = 'description';

    public ?string $partial = null;

    public string $formName = 'Record';

    /** Form field configuration */
    public null|string|array $form = null;

    public string $newRecordTitle = 'New %s';

    public string $editRecordTitle = 'Edit %s';

    public string $emptyMessage = 'igniter::admin.list.text_empty';

    public string $confirmMessage = 'igniter::admin.alert_warning_confirm';

    /**
     * @var bool Items can be sorted.
     */
    public bool $sortable = false;

    /**
     * @var bool Items can be edited.
     */
    public bool $editable = true;

    public ?string $popupSize = null;

    public bool $hideNewButton = true;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'formName',
            'form',
            'newRecordTitle',
            'editRecordTitle',
            'emptyMessage',
            'confirmMessage',
            'editable',
            'sortable',
            'nameFrom',
            'descriptionFrom',
            'partial',
            'popupSize',
            'hideNewButton',
        ]);

        $fieldName = $this->formField->getName(false);
        $this->sortableInputName = self::SORT_PREFIX.$fieldName;

        if ($this->formField->disabled || $this->formField->readOnly) {
            $this->previewMode = true;
        }
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('connector/connector');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('formwidgets/repeater.js', 'repeater-js');

        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->addJs('connector.js', 'connector-js');
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        if (!$this->sortable) {
            return FormField::NO_SAVE_DATA;
        }

        return (array)$this->processSaveValue($value);
    }

    /**
     * Prepares the view data
     */
    public function prepareVars(): void
    {
        $this->vars['formField'] = $this->formField;
        $this->vars['fieldItems'] = $this->processLoadValue() ?? [];

        $this->vars['editable'] = $this->editable;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['nameFrom'] = $this->nameFrom;
        $this->vars['partial'] = $this->partial;
        $this->vars['descriptionFrom'] = $this->descriptionFrom;
        $this->vars['sortableInputName'] = $this->sortableInputName;
        $this->vars['newRecordTitle'] = sprintf($this->newRecordTitle, lang($this->formName));

        $this->vars['emptyMessage'] = $this->emptyMessage;
        $this->vars['confirmMessage'] = $this->confirmMessage;
    }

    #[Override]
    public function reload(): array
    {
        $this->formField->value = null;
        $this->model->reloadRelations();

        return parent::reload();
    }

    public function onRefresh(): array
    {
        $model = $this->getRelationModel();
        if ($recordId = post('recordId', '')) {
            $model = $model->find($recordId);
        }

        $widget = $this->makeItemFormWidget($model);

        return $widget->onRefresh();
    }

    public function onLoadRecord(): string
    {
        $model = $this->getRelationModel();
        $formTitle = lang($this->newRecordTitle);

        if ($recordId = post('recordId', '')) {
            $model = $model->find($recordId);
            $formTitle = lang($this->editRecordTitle);
        }

        if (!$model->exists && method_exists($this->getRelationObject(), 'getForeignKeyName')) {
            $model->{$this->getRelationObject()->getForeignKeyName()} = $this->model->getKey();
        }

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => sprintf($formTitle, lang($this->formName)),
            'formWidget' => $this->makeItemFormWidget($model),
        ]);
    }

    public function onSaveRecord(): array
    {
        $model = $this->getRelationModel();

        if ($recordId = post('recordId', '')) {
            throw_unless($model = $model->find($recordId),
                new FlashException(sprintf(lang('igniter::admin.form.record_not_found_in_model'), $recordId, $model::class)),
            );
        }

        $form = $this->makeItemFormWidget($model);

        $saveData = $this->validateFormWidget($form, $form->getSaveData());

        if (!$model->exists && method_exists($this->getRelationObject(), 'getForeignKeyName')) {
            $saveData[$this->getRelationObject()->getForeignKeyName()] = $this->model->getKey();
        }

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function() use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Item updated'))->now();

        return $this->reload();
    }

    public function onDeleteRecord(): false|array
    {
        if (!$recordId = post('recordId', '')) {
            return false;
        }

        $model = $this->getRelationModel()->find($recordId);
        if (!$model) {
            throw new FlashException(sprintf(lang('igniter::admin.form.not_found'), $recordId));
        }

        $model->delete();

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($this->formName).' deleted'))->now();

        return $this->reload();
    }

    protected function processLoadValue(): mixed
    {
        $value = $this->getLoadValue();
        if (!$this->sortable) {
            return $value;
        }

        return $value instanceof Collection
            ? $value->sortBy($this->sortColumnName)
            : sort_array($value, $this->sortColumnName);
    }

    protected function processSaveValue($value): array|Collection
    {
        $results = [];
        $sortedIndexes = array_flip((array)post($this->sortableInputName));
        if (empty($sortedIndexes)) {
            return $results;
        }

        $items = $this->formField->value;
        if (!$items instanceof Collection) {
            return $items;
        }

        foreach ($items as $index => $item) {
            $results[$index] = [
                $item->getKeyName() => $item->getKey(),
                $this->sortColumnName => $sortedIndexes[$item->getKey()],
            ];
        }

        return $results;
    }

    protected function makeItemFormWidget($model): Form
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'FormConnector';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[connectorData]';
        $widgetConfig['context'] = $model->exists ? 'edit' : 'create';

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
