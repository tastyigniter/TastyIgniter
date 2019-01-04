<?php
$area = $areaForm['data'];
$widget = $areaForm['widget'];
?>
<div
    id="<?= $this->getId('area-'.$index) ?>"
    class="card map-area"
    data-control="area"
    data-area-color="<?= $area['color'] ?>"
    data-index-value="<?= $index ?>"
>
    <div
        class="map-area-header p-3"
        role="tab"
        id="<?= $this->getId('area-header-'.$index) ?>"
    >
        <h5 class="map-area-title">
            <?php if (!$this->previewMode AND $this->sortable) { ?>
                <a
                    class="map-area-handle <?= $this->getId('area-handle-'.$index) ?>"
                    role="button">
                    <i class="fa fa-bars text-black-50"></i>
                </a>&nbsp;&nbsp;
            <?php } ?>
            <span
                class="badge border-circle"
                style="background-color:<?= $area['color']; ?>"
            >&nbsp;</span>
            &nbsp;&nbsp;&nbsp;
            <a
                data-toggle="collapse"
                href="#<?= $this->getId('area-body-'.$index) ?>"
                aria-expanded="true"
                aria-controls="<?= $this->getId('area-body-'.$index) ?>"
                role="button"
            ><?= $area['name']; ?></a>
            <a
                class="close text-danger"
                aria-label="Remove"
                <?php if (!$this->previewMode) { ?>
                    data-control="remove-area"
                    data-area-selector="#<?= $this->getId('area-'.$index) ?>"
                    data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                <?php } ?>
            ><i class="fa fa-times"></i></a>
        </h5>
    </div>
    <div
        id="<?= $this->getId('area-body-'.$index) ?>"
        class="map-area-body p-3 collapse<?= $index == 1 ? ' show' : '' ?>"
        role="tabpanel"
        data-parent="#<?= $this->getId('areas') ?>"
        aria-labelledby="<?= $this->getId('area-header-'.$index) ?>"
    >
        <?= $this->makePartial('maparea/area_form', ['widget' => $widget]) ?>
    </div>

    <input type="hidden" data-map-shape <?= $this->getMapShapeAttributes($index, $area); ?>>
</div>
