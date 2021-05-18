@if (!$this->hasCenter())
    <div class="text-warning fw-500 rounded">
        <b>@lang('admin::lang.locations.alert_missing_map_center')</b>
    </div>
@elseif(!$this->isConfigured())
    <div class="text-warning fw-500 rounded">
        <b>@lang('admin::lang.locations.alert_missing_map_config')</b>
    </div>
@else
    <div
        data-control="map-view"
        data-map-height="{{ $mapHeight }}"
        data-map-zoom="{{ $mapZoom }}"
        data-map-center='@json($mapCenter)'
        data-map-shape-selector="{{ $shapeSelector }}"
        data-map-editable-shape="{{ !$previewMode }}"
    >
        <div class="map-view"></div>
    </div>
@endif
