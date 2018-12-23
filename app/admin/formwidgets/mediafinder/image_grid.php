<div class="media-finder">
    <div class="grid">
        <?php if ($this->previewMode) { ?>
            <a>
                <div class="img-cover">
                    <img src="<?= $this->getMediaThumb($mediaItem) ?>" class="img-responsive">
                </div>
            </a>
        <?php } else { ?>
            <?php if (is_null($mediaItem)) { ?>
                <a class="find-button blank-cover">
                    <i class="fa fa-plus"></i>
                </a>
            <?php } else { ?>
                <i class="find-remove-button fa fa-times-circle" title="<?= lang('admin::lang.text_remove'); ?>"></i>
                <div class="icon-container">
                    <span data-find-name><?= $this->getMediaName($mediaItem) ?></span>
                </div>
                <a class="<?= $useAttachment ? 'find-config-button' : '' ?>">
                    <div class="img-cover">
                        <img data-find-image
                             src="<?= $this->getMediaThumb($mediaItem) ?>"
                             class="img-responsive">
                    </div>
                </a>
            <?php } ?>
            <input
                type="hidden"
                <?= (!is_null($mediaItem) AND !$useAttachment) ? 'name="'.$fieldName.'"' : '' ?>
                value="<?= e($this->getMediaPath($mediaItem)) ?>"
                data-find-value
            />
            <input
                type="hidden"
                value="<?= e($this->getMediaIdentifier($mediaItem)) ?>"
                data-find-identifier
            />
        <?php } ?>
    </div>
</div>
