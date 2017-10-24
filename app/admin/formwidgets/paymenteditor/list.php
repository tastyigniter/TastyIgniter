<div id="<?= $this->getId('activity-modal') ?>" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><?= $listTitle ?></h4>
            </div>
            <div class="modal-body wrap-none">
                <?= $listWidget->render() ?>
            </div>
        </div>
    </div>
</div>
