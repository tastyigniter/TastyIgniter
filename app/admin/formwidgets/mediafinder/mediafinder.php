<div
    id="<?= $this->getId() ?>"
    class="mediafinder <?= $mode ?>-mode<?= $isMulti ? ' is-multi' : '' ?><?= $mode == 'picker' ? ' is-picker' : '' ?><?= $value ? ' is-populated' : '' ?>"
    data-control="mediafinder"
    data-alias="<?= $this->alias ?>"
    data-mode="<?= $mode ?>"
    data-choose-button-text="<?= $chooseButtonText ?>"
    data-use-attachment="<?= $useAttachment ?>"
>
    <?= $this->makePartial('mediafinder/image') ?>

    <?php if ($useAttachment) { ?>
        <script type="text/template" data-config-modal-template>
            <div class="modal-dialog">
                <div id="<?= $this->getId('config-modal-content') ?>">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <span class="spinner"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    <?php } ?>
</div>
