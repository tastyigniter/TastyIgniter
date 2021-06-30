<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Traits\FormModelWidget;

class MapView extends BaseFormWidget
{
    use FormModelWidget;

    /**
     * @var string Partial name containing the toolbar buttons
     */
    public $buttons;

    public $height = 500;

    public $zoom;

    public $center;

    public $shapeSelector = '[data-map-shape]';

    protected $defaultAlias = 'mapview';

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
            'shapeSelector',
        ]);
    }

    public function loadAssets()
    {
        if (strlen($key = setting('maps_api_key'))) {
            $url = 'https://maps.googleapis.com/maps/api/js?key=%s&libraries=geometry';
            $this->addJs(sprintf($url, $key),
                ['name' => 'google-maps-js', 'async' => null, 'defer' => null]
            );
        }

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
        $this->vars['mapHeight'] = (int)$this->height;
        $this->vars['mapZoom'] = (int)$this->zoom;
        $this->vars['mapCenter'] = $this->getCenter();
        $this->vars['shapeSelector'] = $this->shapeSelector;
        $this->vars['previewMode'] = $this->previewMode;
    }

    public function isConfigured()
    {
        return (bool)strlen(trim(setting('maps_api_key')));
    }

    public function hasCenter()
    {
        return (bool)count(array_filter($this->getCenter() ?: []));
    }

    protected function getCenter()
    {
        if ($this->center)
            return $this->center;

        if (method_exists($this->controller, 'mapViewCenterCoords'))
            return $this->controller->mapViewCenterCoords();
    }
}
