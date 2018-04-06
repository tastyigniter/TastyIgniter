<div
    id="<?= $this->getId() ?>"
    data-control="map-area"
    data-area-colors="<?= e(json_encode($areaColors)) ?>"
>
    <div class="row">
        <div class="col-md-4 wrap-none">
            <?= $this->makePartial('maparea/areas') ?>
        </div>

        <div class="col-md-8 wrap-none">
            <?= $mapViewWidget->render() ?>
        </div>
    </div>
</div>
