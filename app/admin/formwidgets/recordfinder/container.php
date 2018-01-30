<?php if ($this->previewMode && !$value) { ?>

    <span class="form-control"><?= e(lang('text_empty')) ?></span>

<?php } else { ?>

    <div class="recordfinder-widget" id="<?= $this->getId('container') ?>">
        <?= $this->makePartial('recordfinder/recordfinder') ?>
    </div>

<?php } ?>