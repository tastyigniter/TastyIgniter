<div class="media-finder">
    <div class="input-group">
        <span class="input-group-prepend">
            <i class="input-group-icon">
                <?php if ($value) { ?>
                    <img
                        data-find-image
                        src="<?= $this->getMediaUrl($value ?: $blankImage) ?>"
                        class="img-responsive"
                        width="24px"
                    >
                <?php } ?>
            </i>
        </span>
        <input
            type="text"
            name="<?= $fieldName ?>"
            class="form-control"
            id="<?= $field->getId() ?>"
            data-find-value
            value="<?= e($value) ?>"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
        >
        <?php if (!$this->previewMode) { ?>
            <span class="input-group-btn">
                <button class="btn btn-primary find-button" type="button">
                    <i class="fa fa-picture-o"></i>
                </button>
                <button class="btn btn-danger find-remove-button" type="button">
                    <i class="fa fa-times-circle"></i>
                </button>
            </span>
        <?php } ?>
    </div>
</div>
