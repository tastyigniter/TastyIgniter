<div
    id="<?= $this->getId('areas') ?>"
    class="h-100"
    role="tablist" aria-multiselectable="true"
    data-control="areas"
>
    <?php foreach ($formWidgets as $index => $areaForm) { ?>
        <?= $this->makePartial('maparea/area_form', ['areaForm' => $areaForm, 'index' => $index]) ?>
    <?php } ?>
</div>