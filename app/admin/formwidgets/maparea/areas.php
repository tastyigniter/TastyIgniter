<div
    id="<?= $this->getId('areas') ?>"
    class="map-areas"
    aria-multiselectable="true"
    data-control="areas"
>
    <?php foreach ($mapAreas as $index => $mapArea) { ?>
        <?= $this->makePartial('maparea/area', ['area' => $mapArea]) ?>
    <?php } ?>
</div>
