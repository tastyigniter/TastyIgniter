<div id="<?= $this->getId('popup') ?>" class="modal recordlist-popup">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="popup">&times;</button>
        <h4 class="modal-title"><?= e(lang($title)) ?></h4>
    </div>

    <div class="list-flush" data-request-data="recordfinder_flag: 1">
        <?= $searchWidget->render() ?>
        <?= $listWidget->render() ?>
    </div>

    <div class="modal-footer">
        <button
            type="button"
            class="btn btn-default"
            data-dismiss="popup">
            Cancel
        </button>
    </div>
</div>

<script>
    setTimeout(
        function () {
            $('#<?= $this->getId('popup') ?> input.form-control:first').focus()
        },
        310
    )
</script>
