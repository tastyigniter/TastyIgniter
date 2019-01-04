<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Traits\FormModelWidget;
use Html;

/**
 * Map Area
 *
 * @package Admin
 */
class MapArea extends BaseFormWidget
{
    use FormModelWidget;

    //
    // Object properties
    //

    protected $defaultAlias = 'maparea';

    protected $prompt = 'lang:admin::lang.locations.text_add_new_area';

    protected $mapPrompt = 'lang:admin::lang.locations.text_edit_area';

    protected $indexCount = 0;

    protected $latFrom;

    protected $lngFrom;

    protected $size = 'normal';

    protected $zoom;

    protected $form;

    protected $areaColors = [
        '#F16745', '#FFC65D',
        '#7BC8A4', '#4CC3D9',
        '#93648D', '#404040',
        '#F16745', '#FFC65D',
        '#7BC8A4', '#4CC3D9',
        '#93648D', '#404040',
        '#F16745', '#FFC65D',
        '#7BC8A4', '#4CC3D9',
        '#93648D', '#404040',
        '#F16745', '#FFC65D',
    ];

    protected $availableSizes = [
        'small' => 360,
        'normal' => 640,
        'large' => 860,
    ];

    protected $shapeDefaultProperties = [
        'id' => null,
        'default' => 'address',
        'options' => [],
        'circle' => [],
        'polygon' => [],
        'vertices' => [],
        'serialized' => FALSE,
        'editable' => FALSE,
    ];

    protected static $onAddItemCalled = FALSE;

    protected $formWidgets = [];

    protected $mapViewWidget;

    public function initialize()
    {
        $this->fillFromConfig([
            'prompt',
            'mapPrompt',
            'latFrom',
            'lngFrom',
            'zoom',
            'size',
            'form',
        ]);

        if (!self::$onAddItemCalled)
            $this->processExistingAreas();
    }

    public function loadAssets()
    {
        $this->addJs('../../repeater/assets/js/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');
        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->addCss('css/maparea.css', 'maparea-css');
        $this->addJs('js/maparea.js', 'maparea-js');
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('maparea/maparea');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['mapViewWidget'] = $this->makeMapViewWidget();
        $this->vars['indexCount'] = $this->indexCount;

        $this->vars['prompt'] = $this->prompt;
        $this->vars['mapPrompt'] = $this->mapPrompt;
        $this->vars['zoom'] = $this->zoom;
    }

    public function getSaveValue($value)
    {
        if ($this->formField->disabled OR $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        if (!is_array($value) && !strlen($value)) {
            return null;
        }

        if (is_array($value) && !count($value)) {
            return null;
        }

        // Give widgets an opportunity to process the data.
        foreach ($this->formWidgets as $index => $form) {
            if (!array_key_exists($index, $value)) continue;
            $value[$index] = $form['widget']->getSaveData();
        }

        return $value;
    }

    public function getLatValue()
    {
        if (!$this->relationModel OR !$this->latFrom) {
            return null;
        }

        return $this->relationModel->{$this->latFrom};
    }

    public function getLngValue()
    {
        if (!$this->relationModel OR !$this->lngFrom) {
            return null;
        }

        return $this->relationModel->{$this->lngFrom};
    }

    public function getAreaColor($key)
    {
        --$key;

        return $this->areaColors[$key] ?? $this->areaColors[0];
    }

    public function onAddArea()
    {
        self::$onAddItemCalled = TRUE;

        $lastCount = post('lastCounter', $this->indexCount);
        $lastCount++;

        $area = [
            'name' => 'Area '.$lastCount,
            'color' => $this->getAreaColor($lastCount),
        ];

        $this->vars['index'] = $lastCount;
        $this->vars['areaForm'] = [
            'data' => $area,
            'widget' => $this->makeAreaFormWidget($lastCount, $area),
        ];

        $itemContainer = '@#'.$this->getId('areas');

        return [
            'areaShapeId' => $this->getId('area-'.$lastCount),
            $itemContainer => $this->makePartial('area'),
        ];
    }

    public function getMapShapeAttributes($index, $area)
    {
        $area = (object)$area;

        $attributes = [
            'data-id' => $this->getId('area-'.$index),
            'data-name' => $area->name,
            'data-default' => $area->type ?? 'address',
            'data-polygon' => $area->boundaries['polygon'] ?? null,
            'data-circle' => $area->boundaries['circle'] ?? null,
            'data-vertices' => $area->boundaries['vertices'] ?? null,
            'data-editable' => $this->previewMode ? 'false' : 'true',
            'data-options' => json_encode([
                'fillColor' => $area->color ?? $this->getAreaColor($index),
                'strokeColor' => $area->color ?? $this->getAreaColor($index),
            ]),
        ];

        return Html::attributes($attributes);
    }

    protected function processExistingAreas()
    {
        $result = [];

        $value = $this->getLoadValue() ?: [];
        foreach ($value as $key => $area) {
            $this->indexCount++;

            if (!isset($area['color']) OR !strlen($area['color']))
                $area['color'] = $this->getAreaColor($this->indexCount);

            $result[$this->indexCount] = [
                'data' => !is_array($area) ? $area->toArray() : $area,
                'widget' => $this->makeAreaFormWidget($this->indexCount, $area),
            ];
        }

        return $this->formWidgets = $result;
    }

    protected function makeMapViewWidget()
    {
        $config = $this->config;

//        $config['shapes'] = $this->getMapShapes();
        $config['center'] = [
            'lat' => $this->model->{$this->latFrom},
            'lng' => $this->model->{$this->lngFrom},
        ];
        $config['zoom'] = $this->zoom;
        $config['height'] = array_get($this->availableSizes, $this->size);

        $widget = $this->makeWidget('Admin\Widgets\MapView', $config);
        $widget->bindToController();

        return $this->mapViewWidget = $widget;
    }

    protected function makeAreaFormWidget($index, $data)
    {
        $config = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $config['model'] = $this->model;
        $config['data'] = $data;
        $config['alias'] = $this->alias.'Form'.$index;
        $config['arrayName'] = $this->formField->getName().'['.$index.']';

        $widget = $this->makeWidget('Admin\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    protected function getMapShapes()
    {
        $result = [];

        foreach ($this->formWidgets as $key => $area) {
            $area = (object)$area['data'];

            $result[] = [
                'id' => $this->getId('area-'.$key), //$area->area_id,
                'type' => $area->type ?? 'polygon',
                'polygon' => $area->boundaries['polygon'],
                'circle' => @json_decode($area->boundaries['circle']),
                'vertices' => @json_decode($area->boundaries['vertices']),
                'editable' => !$this->previewMode,
                'options' => [
                    'fillColor' => $area->color,
                    'strokeColor' => $area->color,
                ],
            ];
        }

        return $result;
    }
}
