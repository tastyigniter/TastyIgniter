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
    const INDEX_SEARCH = '___index__';

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

    protected $valueFromName = 'menu_option_id';

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
            'valueFromName',
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
        $this->vars['keyFromName'] = $this->keyFrom;
        $this->vars['sortableName'] = self::SORT_PREFIX.strtolower($this->alias).'[]';
    }

    public function onAddItem()
    {
        self::$onAddItemCalled = TRUE;

        $postData = post();
        $keyFromValue = array_get($postData, $this->keyFrom);
        if (!strlen($keyFromValue))
            return FALSE;

        $model = $this->createRelatedModelObject($postData);

        $indexCount = $postData['indexValue'] ?? $this->indexCount;
        $indexCount++;

        $this->prepareVars();

        $this->relatedModels[$indexCount] = $model;

        return ['@#'.$this->getId('items') => $this->makePartial('connector/connector_item', [
            'index'  => $indexCount,
            'widget' => $this->makeItemFormWidget($indexCount),
        ])];
    }

    public function onRemoveItem()
    {
        $postData = post();
        $valueFromName = array_get($postData, $this->valueFromName);
        if (!strlen($valueFromName))
            return FALSE;

        $this->getRelationModel()->where($this->valueFromName, $valueFromName)->delete();
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
            $this->makeItemFormWidget($itemIndex);
            $this->indexCount = max((int)$itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget($index = 0)
    {
        $config = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $config['model'] = array_get($this->relatedModels, $index, $this->getRelationModel());
        $config['data'] = array_get($this->getLoadValue(), $index, array_get($this->relatedModels, $index, []));
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

    protected function createRelatedModelObject($postData)
    {
        return $this->getRelationModel()->create(array_merge($postData, [
            $this->model->getKeyName() => $this->model->getKey(),
        ]));
    }

    protected function evalItems($items)
    {
        if (!$items) return $items;

        $dragged = (array)post(self::SORT_PREFIX.strtolower($this->alias));
        $draggedFlipped = array_flip($dragged);

        // Give widgets an opportunity to process the data.
        foreach ($this->formWidgets as $index => $widget) {
            if (!array_key_exists($index, $items)) continue;
//            $items[$index] = $widget->getSaveData();
        }

        foreach ($items as $index => &$item) {
            if ($draggedFlipped AND $this->sortable)
                $item[$this->sortColumn] = $draggedFlipped[$index];
        }

        if ($this->sortColumn AND $this->sortable) {
            $items = ($items instanceof Collection)
                ? $items->sortBy($this->sortColumn)->values()
                : sort_array($items, $this->sortColumn);
        }

        return $items;
    }
}
