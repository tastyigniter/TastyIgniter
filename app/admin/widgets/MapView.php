<?php
namespace Admin\Widgets;

use Admin\Classes\BaseWidget;

class MapView extends BaseWidget
{

    /**
     * @var string Partial name containing the toolbar buttons
     */
    public $buttons;

    public $height = 500;

    protected $zoom;

    protected $center;

    protected $shapes;

    protected $defaultAlias = 'mapview';

    protected $shapeDefaultProperties = [
        'id'         => null,
        'default'    => 'polygon',
        'options'    => [],
        'circle'     => [],
        'polygon'    => [],
        'vertices'   => [],
        'serialized' => false,
        'editable'   => false,
    ];

    protected $previewMode = FALSE;

    /**
     * @var array List of CSS classes to apply to the map container element
     */
    public $cssClasses = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'height',
            'zoom',
            'center',
            'shapes',
        ]);
    }

    public function loadAssets()
    {
        $mapKey = setting('maps_api_key');

        $this->addJs(
            'https://maps.googleapis.com/maps/api/js?key='.$mapKey.'&libraries=geometry',
            'google-maps-js'
        );
        $this->addJs('js/mapview.js', 'mapview-js');
        $this->addJs('js/mapview.shape.js', 'mapview-shape-js');
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('mapview/mapview');
    }

    public function prepareVars()
    {
        $this->vars['mapKey'] = setting('maps_api_key');
        $this->vars['mapHeight'] = (int)$this->height;
        $this->vars['mapZoom'] = (int)$this->zoom;
        $this->vars['mapCenter'] = $this->center;
        $this->vars['mapShapes'] = $this->prepareShapesArray();
        $this->vars['previewMode'] = $this->previewMode;
    }

    protected function prepareShapesArray()
    {
        $result = [];
        foreach ($this->shapes as $key => $shape) {
            if ($shape['type'] != 'shape')
                $shape['default'] = $shape['type'];

            $result[] = array_merge($this->shapeDefaultProperties, $shape);
        }

        return $result;
    }

}
