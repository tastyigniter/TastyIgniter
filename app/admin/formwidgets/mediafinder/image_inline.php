<div class="media-finder">
    <div class="input-group">
        <div class="input-group-prepend">
            <i class="input-group-icon" style="width: 50px;">
                <?php if (!is_null($mediaItem)) { ?>
                    <img
                        data-find-image
                        src="<?= $this->getMediaThumb($mediaItem) ?>"
                        class="img-responsive"
                        width="24px"
                    >
                <?php } ?>
            </i>
        </div>
        <span
            class="form-control<?= (!is_null($mediaItem) AND $useAttachment) ? ' find-config-button' : '' ?>"
            data-find-name><?= e($this->getMediaName($mediaItem)) ?></span>
        <input
            id="<?= $field->getId() ?>"
            type="hidden"
            <?= !$useAttachment ? 'name="'.$fieldName.'"' : '' ?>
            data-find-value
            value="<?= e($this->getMediaPath($mediaItem)) ?>"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
        >
        <input
            type="hidden"
            value="<?= e($this->getMediaIdentifier($mediaItem)) ?>"
            data-find-identifier
        />
        <?php if (!$this->previewMode) { ?>
            <div class="input-group-append">
                <button class="btn btn-outline-primary find-button<?= !is_null($mediaItem) ? ' hide' : '' ?>" type="button">
                    <i class="fa fa-picture-o"></i>
                </button>
                <button
                    class="btn btn-outline-danger find-remove-button<?= !is_null($mediaItem) ? '' : ' hide' ?>"
                    type="button">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div>
        <?php } ?>
    </div>
</div>
