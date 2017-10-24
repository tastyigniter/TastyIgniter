<div class="media-finder">
    <div class="input-group">
    <span class="input-group-addon lg-addon">
        <?php if (!$value) { ?>
            <i class="fa"></i>
        <?php } else { ?>
            <i><img data-find-image
                    src="<?= $this->resizeImage($value ? $value : $blankImage) ?>"
                    class="img-responsive"
                    width="24px"></i>
        <?php } ?>
    </span>
        <input
            type="text"
            name="<?= $fieldName ?>"
            class="form-control"
            id="<?= $field->getId() ?>"
            data-find-value
            value="<?= e($value) ?>"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>
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
