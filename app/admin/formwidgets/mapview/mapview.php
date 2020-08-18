<div
    data-control="map-view"
    data-map-height="<?= $mapHeight; ?>"
    data-map-zoom="<?= $mapZoom; ?>"
    data-map-center="<?= e(json_encode($mapCenter)); ?>"
    data-map-shape-selector="<?= $shapeSelector ?>"
    data-map-editable-shape="<?= !$previewMode ?>"
>
    <div class="map-view"></div>
</div>
