<?php

declare(strict_types=1);

namespace Igniter\Local\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Traits\FormModelWidget;
use Override;

class MapView extends BaseFormWidget
{
    use FormModelWidget;

    public $height = 500;

    public $zoom;

    public $center;

    public $shapeSelector = '[data-map-shape]';

    protected string $defaultAlias = 'mapview';

    /**
     * @var array List of CSS classes to apply to the map container element
     */
    public $cssClasses = [];

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'height',
            'zoom',
            'center',
            'shapeSelector',
        ]);
    }

    #[Override]
    public function loadAssets(): void
    {
        if (strlen((string)($key = setting('maps_api_key'))) !== 0) {
            $url = 'https://maps.googleapis.com/maps/api/js?key=%s&libraries=geometry';
            $this->addJs(sprintf($url, $key),
                ['name' => 'google-maps-js', 'async' => null, 'defer' => null],
            );
        }

        $this->addJs('mapview.js', 'mapview-js');
        $this->addJs('mapview.shape.js', 'mapview-shape-js');
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('mapview/mapview');
    }

    public function prepareVars(): void
    {
        $this->vars['mapHeight'] = (int)$this->height;
        $this->vars['mapZoom'] = (int)$this->zoom;
        $this->vars['mapCenter'] = $this->getCenter();
        $this->vars['shapeSelector'] = $this->shapeSelector;
        $this->vars['previewMode'] = $this->previewMode;
    }

    public function isConfigured(): bool
    {
        return (bool)strlen(trim((string)setting('maps_api_key')));
    }

    public function hasCenter(): bool
    {
        return (bool)count(array_filter($this->getCenter() ?: []));
    }

    protected function getCenter()
    {
        if ($this->center) {
            return $this->center;
        }

        return method_exists($this->controller, 'mapViewCenterCoords')
            ? $this->controller->mapViewCenterCoords()
            : null;
    }
}
