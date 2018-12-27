<div
    id="<?= $this->getId() ?>"
    data-control="map-area"
    data-alias="<?= $this->alias ?>"
    data-last-counter="<?= $indexCount ?>"
>
    <div class="map-area-container">
        <?= $this->makePartial('maparea/areas') ?>
    </div>

    <div
        id="<?= $this->getId('toolbar') ?>"
        class="map-area-toolbar"
    >
        <?= $this->makePartial('maparea/toolbar') ?>
    </div>

    <div
        class="modal fade"
        id="<?= $this->getId('map-modal') ?>"
        tabindex="-1"
        role="dialog"
        aria-labelledby="<?= $this->getId('map-modal-title') ?>"
        aria-hidden="true"
        data-area-map-modal
    >
        <?= $this->makePartial('maparea/map_modal') ?>
    </div>
</div>
