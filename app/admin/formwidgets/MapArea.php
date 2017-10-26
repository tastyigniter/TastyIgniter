<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Widgets\MapView;
use Illuminate\Support\Collection;

/**
 * Map Area
 *
 * @package Admin
 */
class MapArea extends BaseFormWidget
{
    //
    // Object properties
    //

    protected $defaultAlias = 'maparea';

    protected $prompt = 'lang:text_add_new_area';

    protected $relationFrom;

    protected $latFrom;

    protected $lngFrom;

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

    protected $mapViewWidget;

    public function initialize()
    {
        $this->fillFromConfig([
            'prompt',
            'relationFrom',
            'latFrom',
            'lngFrom',
        ]);

        $this->mapViewWidget = $this->makeMapViewWidget();
        $this->mapViewWidget->bindToController();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('maparea/maparea');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['mapViewWidget'] = $this->mapViewWidget;
        $this->vars['areas'] = $this->listAreas();
        $this->vars['conditionsTypes'] = $this->getConditionsTypes();
        $this->vars['prompt'] = $this->prompt;
        $this->vars['areaColors'] = $this->areaColors;
        $this->vars['emptyArea'] = [
            'area_id'    => '%%index%%',
            'type'       => 'polygon',
            'name'       => 'Area %%index%%',
            'boundaries' => [
                'polygon'  => '',
                'circle'   => '',
                'vertices' => '',
            ],
            'conditions' => [],
        ];
        $this->vars['emptyCondition'] = [
            'amount' => 0,
            'type'   => 'all',
            'total'  => 0,
        ];
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();

        if ($value instanceof Collection) {
            $this->relatedModels = $value;
            $value = $value->toArray();
        }

        return $value;
    }

    public function getSaveValue($value)
    {
        if ($this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        if (is_string($value) && !strlen($value)) {
            return null;
        }

        if (is_array($value) && !count($value)) {
            return null;
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
        return (isset($this->areaColors[$key - 1]))
            ? $this->areaColors[$key - 1]
            : '#F16745';
    }

    public function loadAssets()
    {
        $this->addCss('css/maparea.css', 'maparea-css');
        $this->addJs('js/maparea.js', 'maparea-js');
    }

    protected function makeMapViewWidget()
    {
        $config = $this->config;

        $config['shapes'] = $this->prepareMapShapesArray();
        $config['center'] = [
            'lat' => $this->model->{$this->latFrom},
            'lng' => $this->model->{$this->lngFrom},
        ];
        $config['height'] = 640;
        $widget = new MapView($this->getController(), $config);

        return $widget;
    }

    protected function listAreas()
    {
        $result = [];
        $value = $this->getLoadValue();
        if (!is_array($value))
            return $result;

        foreach ($value as $key => $item) {
            $item['conditions'] = $this->parseConditions($item);
            $result[$key] = $item;
        }

        return $result;
    }

    protected function getConditionsTypes()
    {
        return [
            'all'   => lang('text_all_orders'),
            'above' => lang('text_above_order_total'),
            'below' => lang('text_below_order_total'),
        ];
    }

    protected function prepareMapShapesArray()
    {
        $result = [];

        $areas = $this->getLoadValue() ?: [];
        foreach ($areas as $key => $area) {
            $circle = @json_decode($area['boundaries']['circle']);
            if (is_array($circle) AND isset($circle[0]->center))
                $circle = (object)['lat' => $circle[0]->center->lng, 'lng' => $circle[0]->center->lng, 'radius' => $circle[1]->radius];

            $polygonArray = @json_decode($polygon = $area['boundaries']['polygon']);
            if (is_array($polygonArray) AND isset($polygonArray[0]->shape))
                $polygon = $polygonArray[0]->shape;

            $vertices = @json_decode($area['boundaries']['vertices']);

            $result[] = [
                'id'       => $this->getId('area-panel-'.$key),
                'type'     => isset($area['type']) ? $area['type'] : 'polygon',
                'polygon'  => $polygon,
                'circle'   => $circle,
                'vertices' => $vertices,
                'editable' => !$this->previewMode,
                'options'  => [
                    'fillColor'   => $this->getAreaColor($key),
                    'strokeColor' => $this->getAreaColor($key),
                ],
            ];
        }

        return $result;
    }

    protected function parseConditions(array $item)
    {
        if (isset($item['conditions']))
            return $item['conditions'];

        // backward compatibility v2.0
        if (isset($item['charge']) AND is_string($item['charge'])) {
            $item['charge'] = [[
                'amount' => $item['charge'],
                'type'   => (isset($item['type'])) ? $item['type'] : $item['condition'],
                'total'  => (isset($item['min_amount'])) ? $item['min_amount'] : '',
            ]];
        }

        return isset($item['charge']) ? $item['charge'] : [];
    }
}
