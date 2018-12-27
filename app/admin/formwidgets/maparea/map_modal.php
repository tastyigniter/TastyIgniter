<div class="map-modal modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4
                class="modal-title"
                id="<?= $this->getId('map-modal-title') ?>"
            >
                <?= $mapPrompt ? e(lang($mapPrompt)) : '' ?>
                <i class="fa fa-exclamation-circle"
                   title="Select either polygon or circle as area type in order to mark out your delivery area."></i>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body p-0">
            <?= $mapViewWidget->render() ?>
        </div>
    </div>
</div>