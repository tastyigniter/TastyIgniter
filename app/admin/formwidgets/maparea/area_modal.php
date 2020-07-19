<div
    class="modal fade"
    id="<?= $this->getId('area-modal-'.$index) ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="<?= $this->getId('area-modal-label-'.$index) ?>"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $area['name']; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div
                id="<?= $this->getId('area-body-'.$index) ?>"
                class="modal-body"
            >
                <?= $this->makePartial('maparea/area_form', ['widget' => $widget]) ?>
            </div>
        </div>
    </div>
</div>