<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repeater Form Widget
 */
class Repeater extends BaseFormWidget
{
    const INDEX_SEARCH = '___index__';

    const SORT_PREFIX = '___dragged_';

    //
    // Configurable properties
    //

    /**
     * @var array Form field configuration
     */
    public $form;

    /**
     * @var string Prompt text for adding new items.
     */
    public $prompt;

    /**
     * @var bool Items can be sorted.
     */
    public $sortable = FALSE;

    public $sortColumnName = 'priority';

    public $showAddButton = TRUE;

    public $showRemoveButton = TRUE;

    public $emptyMessage = 'lang:admin::lang.text_empty';

    //
    // Object properties
    //

    protected $defaultAlias = 'repeater';

    /**
     * @var int Count of repeated items.
     */
    protected $indexCount = 0;

    protected $itemDefinitions = [];

    protected $sortableInputName;

    /**
     * @var array Collection of form widgets.
     */
    protected $formWidgets = [];

    public function initialize()
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

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('repeater/repeater');
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();
        if ($value instanceof Collection)
            $value = $value->toArray();

        if ($this->sortable) {
            $value = sort_array($value, $this->sortColumnName);
        }

        return $value;
    }

    public function getSaveValue($value)
    {
        return (array)$this->processSaveValue($value);
    }

    /**
     *
     */
    public function loadAssets()
    {
        $this->addJs('js/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('js/repeater.js', 'repeater-js');
    }

    public function prepareVars()
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

    public function getVisibleColumns()
    {
        if (!isset($this->itemDefinitions['fields']))
            return [];

        $columns = [];
        foreach ($this->itemDefinitions['fields'] as $name => $field) {
            if (isset($field['type']) AND $field['type'] == 'hidden')
                continue;

            $columns[$name] = $field['label'] ?? null;
        }

        return $columns;
    }

    public function getFormWidgetTemplate()
    {
        $index = self::INDEX_SEARCH;

        return $this->makeItemFormWidget($index);
    }

    protected function processSaveValue($value)
    {
        if (!is_array($value) OR !$value) return $value;

        $sortedIndexes = (array)post($this->sortableInputName);
        $sortedIndexes = array_flip($sortedIndexes);

        foreach ($value as $index => &$data) {
            if ($sortedIndexes AND $this->sortable)
                $data[$this->sortColumnName] = $sortedIndexes[$index];

            $items[$index] = $data;
        }

        return $value;
    }

    protected function processItemDefinitions()
    {
        $form = $this->form;
        if (!is_array($form))
            $form = $this->loadConfig($form, ['form'], 'form');

        $this->itemDefinitions = ['fields' => array_get($form, 'fields')];
    }

    protected function processExistingItems()
    {
        $loadedIndexes = [];

        $loadValue = $this->getLoadValue();
        if (is_array($loadValue)) {
            $loadedIndexes = array_keys($loadValue);
        }

        $itemIndexes = post($this->sortableInputName, $loadedIndexes);

        if (!count($itemIndexes)) return;

        foreach ($itemIndexes as $itemIndex) {
            $this->formWidgets[$itemIndex] = $this->makeItemFormWidget($itemIndex);
            $this->indexCount = max((int)$itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget($index = 0)
    {
        $config = $this->itemDefinitions;
        $config['model'] = $this->model;
        $config['data'] = $this->getLoadValueFromIndex($index);
        $config['alias'] = $this->alias.'Form'.$index;
        $config['arrayName'] = $this->formField->getName().'['.$index.']';

        $widget = $this->makeWidget('Admin\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * Returns the load data at a given index.
     *
     * @param int $index
     *
     * @return mixed
     */
    protected function getLoadValueFromIndex($index)
    {
        $loadValue = $this->getLoadValue();
        if (!is_array($loadValue)) {
            $loadValue = [];
        }

        return array_get($loadValue, $index, []);
    }
}
