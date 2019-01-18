<div class="media-finder">
    <div class="input-group">
        <span class="input-group-prepend">
            <i class="input-group-icon">
                <?php if (!is_null($mediaItem)) { ?>
                    <img
                        data-find-image
                        src="<?= $this->getMediaThumb($mediaItem) ?>"
                        class="img-responsive"
                        width="24px"
                    >
                <?php } ?>
            </i>
        </span>
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
            <span class="input-group-btn">
                <button class="btn btn-primary find-button<?= !is_null($mediaItem) ? ' hide' : '' ?>" type="button">
                    <i class="fa fa-picture-o"></i>
                </button>
                <button class="btn btn-danger find-remove-button<?= !is_null($mediaItem) ? '' : ' hide' ?>"
                        type="button">
                    <i class="fa fa-times-circle"></i>
                </button>
            </span>
        <?php } ?>
    </div>
</div>
