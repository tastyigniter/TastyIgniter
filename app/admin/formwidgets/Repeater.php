<?php namespace Admin\FormWidgets;

use Exception;
use Admin\Classes\BaseFormWidget;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repeater Form Widget
 */
class Repeater extends BaseFormWidget
{
    const INDEX_SEARCH = '___index__';
    const SORT_PREFIX = '___dragged_';
    const CHECKED_PREFIX = '___checked_';

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

    public $sortColumn = 'priority';

    public $showCheckboxes = FALSE;

    public $radioFrom;

    public $showRadios = FALSE;

    public $checkedFrom;

    //
    // Object properties
    //

    protected $defaultAlias = 'repeater';

    /**
     * @var int Count of repeated items.
     */
    protected $indexCount = 0;

    /**
     * @var array Collection of form widgets.
     */
    public $radioValues = [];

    /**
     * @var array Collection of form widgets.
     */
    public $checkedValues = [];

    /**
     * @var array Collection of form widgets.
     */
    public $formWidgets = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'prompt',
            'sortable',
            'radioFrom',
            'checkedFrom',
            'showRadios',
            'showCheckboxes',
        ]);

        $this->form = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

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

        $value = $this->evalItems($value);

        $this->checkedValues = ($value AND $this->checkedFrom) ? array_filter(array_column($value, $this->checkedFrom)) : [];
        $this->radioValues = ($value AND $this->radioFrom) ? array_filter(array_column($value, $this->radioFrom)) : [];

        return $value;
    }

    public function getSaveValue($value)
    {
        $items = (array)$value;

        $items = $this->evalItems($items);

        return $items;
    }

    /**
     *
     */
    public function loadAssets()
    {
//        $this->addCss('css/repeater.css', 'repeater-css', ['depends'=>'jquery-sortable-js']);
        $this->addJs(assets_url('js/vendor/jquery-sortable.js'), 'jquery-sortable-js');
        $this->addJs('js/repeater.js', 'repeater-js');
    }

    public function prepareVars()
    {
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['widgetTemplate'] = $this->getFormWidgetTemplate();
        $this->vars['formField'] = $this->formField;
        $this->vars['radioValues'] = $this->radioValues;
        $this->vars['checkedValues'] = $this->checkedValues;

        $this->indexCount++;
        $this->vars['nextIndex'] = $this->indexCount;
        $this->vars['prompt'] = $this->prompt;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['showCheckboxes'] = $this->showCheckboxes;
        $this->vars['showRadios'] = $this->showRadios;
        $this->vars['indexSearch'] = self::INDEX_SEARCH;
        $this->vars['sortableName'] = self::SORT_PREFIX.strtolower($this->alias).'[]';
        $this->vars['checkedName'] = self::CHECKED_PREFIX.strtolower($this->alias).'[]';
        $this->vars['radioName'] = self::CHECKED_PREFIX.'radio_'.strtolower($this->alias).'[]';
    }

    public function getVisibleColumns()
    {
        if (!isset($this->form['fields']))
            return [];

        $columns = [];
        foreach ($this->form['fields'] as $name => $field) {
            if (isset($field['type']) AND $field['type'] == 'hidden')
                continue;

            $columns[$name] = isset($field['label']) ? $field['label'] : '';
        }

        return $columns;
    }

    public function getFormWidgetTemplate()
    {
        $index = self::INDEX_SEARCH;
        return $this->makeItemFormWidget($index);
    }

    protected function processExistingItems()
    {
        $itemIndexes = null;

        $loadValue = $this->getLoadValue();
        if (is_array($loadValue)) {
            $itemIndexes = array_keys($loadValue);
        }

        if (!is_array($itemIndexes)) return;

        foreach ($itemIndexes as $itemIndex) {
            $this->formWidgets[$itemIndex] = $this->makeItemFormWidget($itemIndex);
            $this->indexCount = max((int)$itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget($index = 0)
    {
        $loadValue = $this->getLoadValue();
        if (!is_array($loadValue)) $loadValue = [];

        $config = $this->form;
        $config['model'] = $this->model;
        $config['data'] = array_get($loadValue, $index, []);
        $config['alias'] = $this->alias.'Form'.$index;
        $config['arrayName'] = $this->formField->getName().'['.$index.']';

        $widget = $this->makeWidget('Admin\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    protected function evalItems($items)
    {
        if (!$items) return $items;

        $dragged = (array)post(self::SORT_PREFIX.strtolower($this->alias));
        $draggedFlipped = array_flip($dragged);

        $checked = (array)post(self::CHECKED_PREFIX.strtolower($this->alias));
        $radioed = (array)post(self::CHECKED_PREFIX.'radio_'.strtolower($this->alias));

        foreach ($items as $index => &$item) {
            if ($draggedFlipped AND $this->sortable)
                $item[$this->sortColumn] = $draggedFlipped[$index];

            if ($checked AND $this->checkedFrom) {
                $item[$this->checkedFrom] = (int)in_array($index, $checked);
            }

            if ($radioed AND $this->radioFrom) {
                $item[$this->radioFrom] = (int)in_array($index, $radioed);
            }
        }

        if ($this->sortColumn AND $this->sortable)
            $items = sort_array($items, $this->sortColumn);

        return $items;
    }
}
