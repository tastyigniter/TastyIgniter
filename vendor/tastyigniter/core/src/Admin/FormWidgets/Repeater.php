<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Collection;
use Override;

/**
 * Repeater Form Widget
 */
class Repeater extends BaseFormWidget
{
    use FormModelWidget;

    public const INDEX_SEARCH = '@@index';

    public const SORT_PREFIX = '___dragged_';

    //
    // Configurable properties
    //

    /** Form field configuration */
    public null|string|array $form = null;

    /** Prompt text for adding new items. */
    public ?string $prompt = null;

    /** Items can be sorted. */
    public bool $sortable = false;

    public string $sortColumnName = 'priority';

    public bool $showAddButton = true;

    public bool $showRemoveButton = true;

    public string $emptyMessage = 'lang:igniter::admin.text_empty';

    //
    // Object properties
    //

    protected string $defaultAlias = 'repeater';

    /** Count of repeated items. */
    protected int $indexCount = 0;

    protected array $itemDefinitions = [];

    protected ?string $sortableInputName = null;

    /**
     * @var array Collection of form widgets.
     */
    protected array $formWidgets = [];

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'prompt',
            'emptyMessage',
            'sortable',
            'sortColumnName',
            'showAddButton',
            'showRemoveButton',
        ]);

        $this->processItemDefinitions();

        $fieldName = $this->formField->getId();
        $this->sortableInputName = self::SORT_PREFIX.$fieldName;

        $this->processExistingItems();
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        // Apply preview mode to widgets
        foreach ($this->formWidgets as $widget) {
            $widget->previewMode = $this->previewMode;
        }

        return $this->makePartial('repeater/repeater');
    }

    #[Override]
    public function getLoadValue(): mixed
    {
        $value = parent::getLoadValue();

        if (!$this->sortable) {
            return $value;
        }

        if (is_array($value)) {
            $value = sort_array($value, $this->sortColumnName);
        } elseif ($value instanceof Collection) {
            $value = $value->sortBy($this->sortColumnName);
        }

        return $value;
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        return (array)$this->processSaveValue($value);
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('repeater.js', 'repeater-js');
    }

    public function prepareVars(): void
    {
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['widgetTemplate'] = $this->getFormWidgetTemplate();
        $this->vars['formField'] = $this->formField;

        $this->indexCount++;
        $this->vars['nextIndex'] = $this->indexCount;
        $this->vars['prompt'] = $this->prompt;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['emptyMessage'] = $this->emptyMessage;
        $this->vars['showAddButton'] = $this->showAddButton;
        $this->vars['showRemoveButton'] = $this->showRemoveButton;
        $this->vars['indexSearch'] = self::INDEX_SEARCH;
        $this->vars['sortableInputName'] = $this->sortableInputName;
    }

    public function getVisibleColumns(): array
    {
        if (!isset($this->itemDefinitions['fields'])) {
            return [];
        }

        $columns = [];
        foreach ($this->itemDefinitions['fields'] as $name => $field) {
            if (isset($field['type']) && $field['type'] == 'hidden') {
                continue;
            }

            $columns[$name] = $field['label'] ?? null;
        }

        return $columns;
    }

    public function getFormWidgetTemplate(): Form
    {
        $index = self::INDEX_SEARCH;

        return $this->makeItemFormWidget($index, []);
    }

    protected function processSaveValue(mixed $value): mixed
    {
        if (!is_array($value) || !$value) {
            return $value;
        }

        $sortedIndexes = (array)post($this->sortableInputName);
        $sortedIndexes = array_flip($sortedIndexes);

        foreach ($value as $index => &$data) {
            if ($sortedIndexes && $this->sortable) {
                $data[$this->sortColumnName] = $sortedIndexes[$index];
            }
        }

        return $value;
    }

    protected function processItemDefinitions()
    {
        $form = $this->form;
        if (!is_array($form)) {
            $form = $this->loadConfig($form, ['form'], 'form');
        }

        $this->itemDefinitions = ['fields' => array_get($form, 'fields')];
    }

    protected function processExistingItems()
    {
        $loadedIndexes = [];

        $loadValue = $this->getLoadValue();
        if (is_array($loadValue)) {
            $loadedIndexes = array_keys($loadValue);
        } elseif ($loadValue instanceof Collection) {
            $loadedIndexes = $loadValue->keys()->all();
        }

        $itemIndexes = post($this->sortableInputName, $loadedIndexes);

        if (count($itemIndexes) === 0) {
            return;
        }

        foreach ($itemIndexes as $itemIndex) {
            $model = $this->getLoadValueFromIndex($loadValue, $itemIndex);
            $this->formWidgets[$itemIndex] = $this->makeItemFormWidget($itemIndex, $model);
            $this->indexCount = max((int)$itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget(int|string $index, $model): Form
    {
        $data = null;
        if (!$model instanceof Model) {
            $data = $model;
            $model = $this->getRelationModel();
        }

        $config = $this->itemDefinitions;
        $config['model'] = $model;
        $config['data'] = $data;
        $config['alias'] = $this->alias.'Form'.$index;
        $config['arrayName'] = $this->formField->getName().'['.$index.']';

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * Returns the load data at a given index.
     */
    protected function getLoadValueFromIndex(mixed $loadValue, mixed $index): mixed
    {
        if ($loadValue instanceof Collection) {
            return $loadValue->get($index);
        }

        return array_get($loadValue, $index, []);
    }

    protected function getRelationModel(): Model
    {
        [$model, $attribute] = $this->resolveModelAttribute($this->valueFrom);

        if (!$model instanceof Model || !$model->hasRelation($attribute)) {
            return $this->model;
        }

        $related = $model->makeRelation($attribute);

        if (!$related->exists) {
            $related->{$this->model->getKeyName()} = $this->model->getKey();
        }

        return $related;
    }
}
