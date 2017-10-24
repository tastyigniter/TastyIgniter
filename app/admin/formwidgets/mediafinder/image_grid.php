<div class="media-finder">
    <div class="grid">
        <?php if ($this->previewMode) { ?>
            <a>
                <div class="img-cover">
                    <img src="<?= $this->resizeImage($value ? $value : $blankImage) ?>" class="img-responsive">
                </div>
            </a>
        <?php } else { ?>
            <?php if (!$value) { ?>
                <a class="find-button blank-cover">
                    <i class="fa fa-plus"></i>
                </a>
            <?php } else { ?>
                <i class="find-remove-button fa fa-times-circle" title="<?= lang('text_remove'); ?>"></i>
                <div class="icon-container">
                    <span data-find-name><?= ltrim($value, '/') ?></span>
                </div>
                <a class="find-button">
                    <div class="img-cover">
                        <img data-find-image src="<?= $this->resizeImage($value ? $value : $blankImage) ?>" class="img-responsive">
                    </div>
                </a>
            <?php } ?>
            <input
                type="hidden"
                name="<?= $fieldName ?>"
                value="<?= e($value) ?>"
                data-find-value
            />
        <?php } ?>
    </div>
</div>
