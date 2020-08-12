<div
    id="<?= $this->getId() ?>"
    data-control="map-area"
    data-alias="<?= $this->alias ?>"
    data-last-counter="<?= $indexCount ?>"
>
    <div class="map-area-container my-3">
        <?= $this->makePartial('maparea/areas') ?>
    </div>

    <div
        id="<?= $this->getId('toolbar') ?>"
        class="map-area-toolbar"
    >
        <?= $this->makePartial('maparea/toolbar') ?>
    </div>
</div>
