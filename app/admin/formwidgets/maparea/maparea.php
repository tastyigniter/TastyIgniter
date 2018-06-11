<div
    id="<?= $this->getId() ?>"
    data-control="map-area"
    data-alias="<?= $this->alias ?>"
    data-area-colors="<?= e(json_encode($areaColors)) ?>"
    data-last-counter="<?= $indexCount ?>"
>
    <div
        id="<?= $this->getId('toolbar') ?>"
        class="map-area-toolbar"
    >
        <?= $this->makePartial('maparea/toolbar') ?>
    </div>

    <div class="row no-gutters">
        <div class="map-area-container col-sm-5 order-sm-1">
            <?= $this->makePartial('maparea/areas') ?>
        </div>

        <div class="map-view-container flex-fill col-sm-7 order-sm-0">
            <?= $mapViewWidget->render() ?>
        </div>
    </div>
</div>
