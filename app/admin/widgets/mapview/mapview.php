<div
    data-control="map-view"
    data-map-height="<?= $mapHeight; ?>"
    data-map-zoom="<?= $mapZoom; ?>"
    data-map-center="<?= e(json_encode($mapCenter)); ?>"
    data-map-editable-shape="<?= !$previewMode ?>"
>
    <?php foreach ($mapShapes as $index => $area) { ?>
        <input type="hidden" data-map-shape="<?= e(json_encode($area)); ?>">
    <?php } ?>

    <?php if (strlen($mapKey)) { ?>
    <div class="map-view"></div>
    <?php } else { ?>
        <p>Missing google maps API key. Add one under General Settings</p>
    <?php } ?>

</div>
