<?php
$area = $areaForm['data'];
$widget = $areaForm['widget'];
?>
<div
    id="<?= $this->getId('area-'.$index) ?>"
    class="h-100<?= $index == 1 ? '' : ' hide' ?>"
    data-control="area"
    data-area-color="<?= $area['color'] ?>"
    data-index-value="<?= $index ?>"
>
    <div
        class="pt-1"
        style="background-color:<?= $area['color']; ?>"
    ></div>
    <div class="form-fields bg-light h-100">
        <?php foreach ($widget->getFields() as $field) { ?>
            <?= $widget->renderField($field) ?>
        <?php } ?>
    </div>
</div>
