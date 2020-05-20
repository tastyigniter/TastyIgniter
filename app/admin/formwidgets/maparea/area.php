<?php
$area = $areaForm['data'];
$widget = $areaForm['widget'];
?>
<div
    id="<?= $this->getId('area-'.$index) ?>"
    class="map-area card bg-light shadow-sm mb-2"
    data-control="area"
    data-area-color="<?= $area['color'] ?>"
    data-index-value="<?= $index ?>"
>
    <div
        class="card-body"
        role="tab"
        id="<?= $this->getId('area-header-'.$index) ?>"
    >
        <div class="d-flex w-100 justify-content-between">
            <?php if (!$this->previewMode AND $this->sortable) { ?>
                <div class="align-self-center mr-3">
                    <a
                        class="map-area-handle <?= $this->getId('area-handle-'.$index) ?>"
                        role="button">
                        <i class="fa fa-bars text-black-50"></i>
                    </a>&nbsp;&nbsp;
                </div>
            <?php } ?>
            <div class="align-self-center mr-3">
                 <span
                     class="badge border-circle"
                     style="background-color:<?= $area['color']; ?>"
                 >&nbsp;</span>
            </div>
            <div
                class="flex-fill"
                data-toggle="modal"
                data-target="#<?= $this->getId('area-modal-'.$index) ?>"
                aria-expanded="true"
                role="button"
            ><b><?= $area['name']; ?></b></div>
            <div class="align-self-center ml-auto">
                <a
                    class="close text-danger"
                    aria-label="Remove"
                    <?php if (!$this->previewMode) { ?>
                        data-control="remove-area"
                        data-area-selector="#<?= $this->getId('area-'.$index) ?>"
                        data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                    <?php } ?>
                ><i class="fa fa-trash-alt"></i></a>
            </div>
        </div>
    </div>

    <?= $this->makePartial('maparea/area_modal', ['index' => $index, 'area' => $area, 'widget' => $widget]) ?>

    <input type="hidden" data-map-shape <?= $this->getMapShapeAttributes($index, $area); ?>>
</div>
