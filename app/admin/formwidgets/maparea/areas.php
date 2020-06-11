<div
    id="<?= $this->getId('areas') ?>"
    class="map-areas"
    aria-multiselectable="true"
    data-control="areas"
>
    <?php foreach ($formWidgets as $index => $areaForm) { ?>
        <?= $this->makePartial('maparea/area', ['areaForm' => $areaForm, 'index' => $index]) ?>
    <?php } ?>
</div>