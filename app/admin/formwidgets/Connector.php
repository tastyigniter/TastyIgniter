<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Form Relationship
 *
 * @package Admin
 */
class Connector extends BaseFormWidget
{
    const SORT_PREFIX = '___dragged_';

    //
    // Object properties
    //

    protected $defaultAlias = 'connector';

    /**
     * @var int Count of repeated items.
     */
    protected $indexCount = 0;

    public $sortColumn = 'priority';

    /**
     * @var array Collection of form widgets.
     */
    public $formWidgets = [];

    protected $relatedModels = [];

    //
    // Configurable properties
    //

    /**
     * @var bool Stops nested repeaters populating from previous sibling.
     */
    protected static $onAddItemCalled = FALSE;

    /**
     * @var string Model column to use for the name reference
     */
    protected $keyFrom = 'option_id';

    /**
     * @var array Form field configuration
     */
    public $form;

    /**
     * @var string Prompt text for adding new items.
     */
    public $prompt = 'lang:admin::default.text_please_select';

    /**
     * @var bool Items can be sorted.
     */
    public $sortable = FALSE;

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'prompt',
            'sortable',
            'keyFrom',
        ]);

        if (!self::$onAddItemCalled) {
            $this->processExistingItems();
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('connector/connector');
    }

    public function loadAssets()
    {
        $this->addJs(assets_url('js/vendor/jquery-sortable.js'), 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');
        $this->addJs('js/connector.js', 'connector-js');
    }

    public function getSaveValue($value)
    {
        $items = (array)$value;

        if (!$this->sortable)
            return $items;

        $items = $this->evalItems($items);

        return $items;
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();
        if ($value instanceof Collection) {
            $this->relatedModels = $value;
            $value = $value->toArray();
        }

        $value = $this->evalItems($value);

        return $value;
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['formField'] = $this->formField;
        $this->vars['fieldOptions'] = $this->formField->options();

        $this->vars['prompt'] = $this->prompt;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['sortableName'] = self::SORT_PREFIX.strtolower($this->alias).'[]';
    }

    public function getFormWidgetTitle($widget, $options)
    {
        if (!$widget->data)
            return null;

        $keyValue = $widget->data->{$this->keyFrom};

        return isset($options[$keyValue]) ? $options[$keyValue] : '';
    }

    public function onAddItem()
    {
        self::$onAddItemCalled = TRUE;

        $postData = post();
        if (!$postData)
            return FALSE;

        $model = $this->createRelatedModelObject($postData);

        $indexCount = is_numeric($postData['indexValue']) ? $postData['indexValue'] : $this->indexCount;
        $indexCount++;

        $this->prepareVars();

        $this->relatedModels[$indexCount] = $model;
        $loadValue[$indexCount] = $model->toArray();
        $this->vars['widget'] = $this->makeItemFormWidget($indexCount, $loadValue);
        $this->vars['index'] = $indexCount;

        $itemContainer = '@#'.$this->getId('items');

        return [$itemContainer => $this->makePartial('connector/connector_item')];
    }

    /**
     * Returns the final model and attribute name of
     * a nested HTML array attribute.
     * Eg: list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
     *
     * @param  string $attribute .
     *
     * @return array
     */
    public function resolveModelAttribute($attribute)
    {
        return $this->formField->resolveModelAttribute($this->model, $attribute);
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
            $this->makeItemFormWidget($itemIndex, $loadValue);
            $this->indexCount = max((int)$itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget($index = 0, $loadValue)
    {
        if (!is_array($loadValue)) $loadValue = [];

        $data = array_get($loadValue, $index, []);
        $config = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $config['model'] = array_get($this->relatedModels, $index, $this->createRelatedModelObject($data));
        $config['data'] = $data;
        $config['alias'] = $this->alias.'Form'.$index;
        $config['arrayName'] = $this->formField->getName().'['.$index.']';

        $widget = $this->makeWidget('Admin\Widgets\Form', $config);
        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $this->formWidgets[$index] = $widget;
    }

    /**
     * Returns the value as a relation object from the model,
     * supports nesting via HTML array.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationModel()
    {
        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->valueFrom
            ));
        }

        return $model->makeRelation($attribute);
    }

    /**
     * Returns the value as a relation object from the model,
     * supports nesting via HTML array.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationObject()
    {
        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->valueFrom
            ));
        }

        return $model->{$attribute}();
    }

    /**
     * @param $postData
     *
     * @return mixed
     */
    protected function createRelatedModelObject($postData)
    {
        $model = $this->getRelationModel()->newInstance(array_merge($postData, [
            $this->model->getKeyName() => $this->model->getKey(),
        ]));

        return $model;
    }

    protected function evalItems($items)
    {
        if (!$items) return $items;

        $dragged = (array)post(self::SORT_PREFIX.strtolower($this->alias));
        $draggedFlipped = array_flip($dragged);

        // Give widgets an opportunity to process the data.
        foreach ($this->formWidgets as $index => $widget) {
            if (!array_key_exists($index, $items)) continue;
            $items[$index] = $widget->getSaveData();
        }

        foreach ($items as $index => &$item) {
            if ($draggedFlipped AND $this->sortable)
                $item[$this->sortColumn] = $draggedFlipped[$index];
        }

        if ($this->sortColumn AND $this->sortable)
            $items = sort_array($items, $this->sortColumn);

        return $items;
    }
}
